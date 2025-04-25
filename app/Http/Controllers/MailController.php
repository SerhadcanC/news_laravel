<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\MailQueue;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\Assert as PHPUnit;

class MailController extends Controller
{
    public function send_mail(Request $request)
    {
        //$job = (new MailQueue($request->email))->withFakeQueueInteractions();
        //$job->handle();
        //PHPUnit::assertTrue($job->is_done, "Mail not sent");

        Bus::chain([
            new MailQueue($request->email),
            new MailQueue($request->email),
            new MailQueue($request->email),
        ])->dispatch();
    }
}
