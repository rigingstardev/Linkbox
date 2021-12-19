<?php namespace App\Modules\Patient\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Patient;
use App\Models\Physician;
use App\Models\Questions;
use App\Models\QuestionReceipients;
use App\Models\QuestionsCategory;
use App\Models\QuestionReceipientsAnswers;
use Illuminate\Support\Facades\Auth;
    use Vinkla\Hashids\Facades\Hashids;
//Repositories
//use App\Modules\Patient\Repositories\QuestionReceipientRepository;
// DataTable
// use Yajra\Datatables\Facades\Datatables;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\Physician\Repositories\NotificationsRepository;

class QuestionController extends Controller
{
    protected $guard;
    
    public function __construct() {
        $this->guard = 'patient';
        Auth::shouldUse('patient');
    }

    /**
     * Received Question Sets of Patient.
     *
     * @return Response
     */
    public function questions()
    {
        return view("Patient::question.list");
    }

    /**
     * Ajax content for Listing
     * @param $request
     * @param string $search
     * @return JSON Response
     */
    public function getList(Request $request)
    {
        $patientId = \Auth::Guard('patient')->user()->id;
        $questions = QuestionReceipients::join('questions', 'questions.id', '=', 'question_id')
                ->join('users', 'users.id', '=', 'questions.user_id')
                ->where('patient_id', $patientId)
                ->where('status', '<>', 'completed')
                ->select('questions.*','question_recipients.created_at as received_date', 'question_recipients.id as qResId', 'users.name as physician', 'users.hospital_name as clinic', 'users.contact_number as contact_no')->where('questions.active', 'Y');
        return Datatables::of($questions)
                ->addColumn('title', function($questions) {
                    return '<a href="' . route('patient.question.brief', Hashids::encode($questions->qResId)) . '">' . $questions->title . '</a>';
                })
                ->addColumn('created_at', function($questions) {
                    return (!empty($questions->received_date)) ? date('m/d/Y', strtotime($questions->received_date)) : "";
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('search')) {
                        $searchText = $request->get('search');
                        $instance->where(function ($query) use ($searchText) {
                            $query->orWhere('name', 'like', "%{$searchText}%")
                            ->orWhere('email', 'like', "%{$searchText}%");
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Brief Details of A question
     * @param $request
     * @param string $search
     * @return JSON Response
     */
    public function briefDetails(Request $request)
    {
        //$questReceipientsRepo  = new QuestionReceipientRepository();
        $patientId       = \Auth::Guard('patient')->user()->id;
        $qResId          = Hashids::decode($request->id);
        $questiondetails = QuestionReceipients::join('questions', 'questions.id', '=', 'question_recipients.question_id')
                ->join('users', 'users.id', '=', 'questions.user_id')
                ->where('question_recipients.id', $qResId)
                ->select('questions.*', 'question_recipients.id as qResId', 'users.name as physician', 'users.hospital_name as clinic', 'users.city as city', 'users.profile_description', 'users.profile_image')->where('questions.active', 'Y')->first();

        if (empty($qResId) || count((array)$questiondetails) == 0) {
            return redirect()->back()->with('error', trans('Patient::messages.unauthorized'));
        }
        return view("Patient::question.briefDesc", compact('questiondetails'));
    }

    /**
     * To view Question Set
     * @param $request
     * @param string $search
     * @return JSON Response
     */
    public function show(Request $request)
    {

        $qResId       = Hashids::decode($request->id);
        //dd($request->id);
        // get questions and its answer methods
        // If the user is authorized allow them to view the deatils
        $patientId    = \Auth::Guard('patient')->user()->id;
        //$qRecId = QuestionReceipients::where('id',$qResId)->first(['id']);
        $questionSets = QuestionReceipients::with('question', 'question.questionSets', 'question.questionSets.defaultOptions', 'answers', 'question.questionSets.category', 'question.questionSets.yesNoQuestions', 'question.questionSetsyesNoCount')->leftJoin('questions', 'question_recipients.question_id', 'questions.id')->select('question_recipients.*')->where('questions.active', 'Y')->where('question_recipients.id', $qResId)->get();
        // dd($questionSets);
        if (empty($qResId) || $questionSets->isEmpty()) {
            return redirect('home'); //->back()->with('error', trans('Patient::messages.unauthorized'));
        }
        $categories = $questionSets->map(function ($value) {
            return $value->question->questionSets->sortBy('category.sort_order')->pluck('category.category', 'category.id');
        });


        /* $questionSets = $questionSets->map(function ($value) {
          return $value->question->questionSets->sortBy('category.sort_order');
          }); */

        $category = $categories->all();
        $category = end($category)->unique();
        /*
          echo "<pre>";
          print_r($questionSets);
          print_r($qs);

          die; */

        return view("Patient::question.show", compact('questionSets', 'category'));
    }

    /**
     * To Update Question Set Answers
     * @param $request
     * @param string $search
     * @return JSON Response
     */
    public function postAnswer(Request $request, NotificationsRepository $notificationsRepo)
    {

        $qRecId    = Hashids::decode($request->id);
        $qRecId    =  $qRecId[0];
        $questions = $request->all();

        $patientId           = \Auth::Guard('patient')->user()->id;
        $questionReceipients = QuestionReceipients::where('id', $qRecId)->first();

        $receivedAnswers       = [];
        $receivedAnswersUpdate = [];
        $descriptions          = [];
        $answered              = 0;
        foreach ($questions['answer'] as $questKey => $questVal) {
            $description = "";
            foreach ($questVal as $ansKey => $ansVal) {
                if (isset($questions['description'])) {
                    if (array_key_exists($questKey, $questions['description'])) {
                        $description = $questions['description'][$questKey][$ansKey];
                    }
                }
                if (!empty($ansVal) || !empty($description))
                    $answered++;

                if (is_array($ansVal)) {
                    if (array_key_exists('3combo', $ansVal)) {
                        $ansVal = serialize(array_values($ansVal['3combo']));
                    } else {
                        $ansVal = serialize(array_keys($ansVal));
                    }
                }
              
                $exists = QuestionReceipientsAnswers::where('question_recipient_id', $qRecId)->where('question_category_id', $questKey)->first();
                if ($exists) {

                    $exists->answer      = $ansVal;
                    $exists->description = $description;
                    $exists->save();
                    if (empty($exists->answer) && empty($exists->description)) {
                        $exists->delete();
                    }
                    // if empty answers delete this row
                } else {
                    if (!empty($ansVal) || !empty($description)) {

                        $receivedAnswers[] = [
                            'question_recipient_id' => $qRecId,
                            'question_id' => $questionReceipients['question_id'],
                            'question_category_id' => $questKey,
                            'answer' => $ansVal,
                            'description' => $description
                        ];
                    }
                }
            }
        }
        if ($answered == 0) {
            //return redirect()->back()->with('error', trans('Patient::messages.error_message'));
            \Session::flash('error', trans('Patient::messages.error_message'));
            return json_encode(array('success' => false, 'message' => trans('Patient::messages.error_message'), 'redirectUrl' => route('patient.question.show', $qRecId)));
        }
        // if save update status of question receipient
        if (!empty($receivedAnswers))
            QuestionReceipientsAnswers::insert($receivedAnswers);

// updating notification as seen.
        $notifDetails = $notificationsRepo->getID(array('is_seen' => 0, 'question_id' => $questionReceipients['question_id'], 'receiver_id' => $patientId, 'receiver_type' => 2, 'question_recipients_id' => $qRecId));
        if (count((array)$notifDetails) > 0) {
            $notifId      = $notifDetails->id;
            $notificationsRepo->updateData(array('notifId' => $notifId, 'nid' => $notifId), array('is_seen' => 1));
            // sending notification
            $notification = $notificationsRepo->save(array('question_id' => $questionReceipients['question_id'], 'notification_type' => 1, 'message' => 'trans_received_response', 'sender_id' => $patientId, 'sender_type' => 3, 'question_recipients_id' => $qRecId, 'receiver_id' => $questionReceipients['physician_id'], 'receiver_type' => 1));
        }
        $recStatus                   = ('2' == $questions['saved']) ? 'completed' : 'responded';
        $questionReceipients->status = $recStatus;
        $questionReceipients->save();
        $succMsg                     = ('2' == $questions['saved']) ? trans('Patient::messages.submit_answer') : trans('Patient::messages.saved_answer');

        \Session::flash('success', $succMsg);
        return json_encode(array('success' => true, 'message' => $succMsg, 'redirectUrl' => route('patient.question.show', Hashids::encode($qRecId))));
        //return redirect()->back()->with('success', trans('Patient::messages.saved_answer'));
    }
}
