<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Modules\Physician\Models\Physician;

class SummaryReport extends Mailable
{
    use Queueable, SerializesModels;
    
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->data = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->data->report_type =='E')
            $subject = ' - Full Evaluation Report Sent';
        else
            $subject = ' - Summary Report Sent';
        
        return $this->view('emails.summary_report')
                ->subject(config('app.name') . $subject)
                ->attach(realpath($this->data->pdf_file), [
//            'as' => 'name.pdf',
            'mime' => 'application/pdf',
        ])->with(['user' => $this->data]);
    }
}
