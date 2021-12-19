<?php

namespace App\Session;

use Carbon\Carbon;
use SessionHandlerInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Auth;
use Yajra\Auditable\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class DatabaseSessionHandler extends \Illuminate\Session\DatabaseSessionHandler {

    use AuditableTrait;
    use \OwenIt\Auditing\Auditable;
    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName) {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId) {
        $session = (object) $this->getQuery()->find($sessionId);

        if (isset($session->last_activity)) {
            if ($session->last_activity < Carbon::now()->subMinutes($this->minutes)->getTimestamp()) {
                $this->exists = true;

                return;
            }
        }

        if (isset($session->payload)) {
            $this->exists = true;

            return base64_decode($session->payload);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data) {
        $payload = $this->getDefaultPayload($data);
        
        if (!$this->exists) {
            $this->read($sessionId);
        }

        if ($this->exists) {
            $this->performUpdate($sessionId, $payload);
        } else {
            $this->performInsert($sessionId, $payload);
        }

        $this->exists = true;
        
        return true;
    }

    /**
     * Perform an insert operation on the session ID.
     *
     * @param  string  $sessionId
     * @param  string  $payload
     * @return void
     */
    protected function performInsert($sessionId, $payload) {
        try {
            $payload['id'] = $sessionId;

            return $this->getQuery()->insert($payload);
        } catch (QueryException $e) {
            $this->performUpdate($sessionId, $payload);
        }
    }

    /**
     * Perform an update operation on the session ID.
     *
     * @param  string  $sessionId
     * @param  string  $payload
     * @return int
     */
    protected function performUpdate($sessionId, $payload) {
        
        return $this->getQuery()->where('id', $sessionId)->update($payload);
    }

    /**
     * Get the default payload for the session.
     *
     * @param  string  $data
     * @return array
     */
    protected function getDefaultPayload($data) {
        $payload = ['payload' => base64_encode($data), 'last_activity' => Carbon::now()->getTimestamp()];

        if (!$container = $this->container) {
            return $payload;
        }
        if ($container->bound(Guard::class)) {

            $payload['user_id'] = $container->make(Guard::class)->id();
            $payload['user_type'] = 'D';
        }
        if (Auth::guard('patient')->check()) {

            $payload['user_id'] = Auth::guard('patient')->User()->id;
            $payload['user_type'] = 'P';
        }
        if (Auth::guard('admin')->check()) {

            $payload['user_id'] = Auth::guard('admin')->User()->id;
            $payload['user_type'] = 'A';
        }

        if ($container->bound('request')) {
            $payload['ip_address'] = $container->make('request')->ip();

            $payload['user_agent'] = substr(
                    (string) $container->make('request')->header('User-Agent'), 0, 500
            );
        }
        $payload['session_identifier'] = session('session_identifier');
        return $payload;

    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId) {
        $this->getQuery()->where('id', $sessionId)->delete();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($lifetime) {
        $this->getQuery()->where('last_activity', '<=', Carbon::now()->getTimestamp() - $lifetime)->delete();
    }

    /**
     * Get a fresh query builder instance for the table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getQuery() {
        return $this->connection->table($this->table);
    }

    /**
     * Set the existence state for the session.
     *
     * @param  bool  $value
     * @return $this
     */
    public function setExists($value) {
        $this->exists = $value;

        return $this;
    }

}
