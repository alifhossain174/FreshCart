<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use CURLFile;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupportTicketController extends Controller
{
    public function supportTickets(){
        $supportTickets = DB::table('support_tickets')->where('support_taken_by', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('dashboard.support_tickets', compact('supportTickets'));
    }

    public function createTicket(){
        return view('dashboard.create_ticket');
    }

    public function saveSupportTicket(Request $request){

        $attachment = NULL;
        if ($request->hasFile('image')){
            $get_attachment = $request->file('image');
            $attachment_name = str::random(5) . time() . '.' . $get_attachment->getClientOriginalExtension();
            $location = public_path('support_ticket_attachments/');
            $get_attachment->move($location, $attachment_name);
            $attachment = "support_ticket_attachments/" . $attachment_name;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('ADMIN_URL').'/api/upload/support/ticket/file',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'attachment'=> new CURLFile(public_path($attachment))
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }

        DB::table('support_tickets')->insert([
            'ticket_no' => time(),
            'support_taken_by' => Auth::user()->id,
            'subject' => $request->topic." : ".$request->subject,
            'message' => $request->description,
            'attachment' => $attachment,
            'slug' => time().str::random(5),
            'status' => 0,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Support Ticket is created');
        return redirect('support/tickets');

    }

    public function supportTicketMessage($slug){
        $supportTicket = DB::table('support_tickets')
                            ->leftJoin('users', 'support_tickets.support_taken_by', 'users.id')
                            ->select('support_tickets.*', 'users.image as user_image', 'users.name as user_name')
                            ->where('support_tickets.slug', $slug)
                            ->first();

        $supportTicketMessages = DB::table('support_messages')
                                ->leftJoin('users', 'support_messages.sender_id', 'users.id')
                                ->select('support_messages.*', 'users.image as user_image', 'users.name as user_name')
                                ->where('support_ticket_id', $supportTicket->id)
                                ->orderBy('id', 'asc')
                                ->get();

        return view('dashboard.support_ticket_message', compact('supportTicket', 'supportTicketMessages'));
    }

    public function sendSupportMessage(Request $request){

        $attachment = NULL;
        if ($request->hasFile('image')){
            $get_attachment = $request->file('image');
            $attachment_name = str::random(5) . time() . '.' . $get_attachment->getClientOriginalExtension();
            $location = public_path('support_ticket_attachments/');
            $get_attachment->move($location, $attachment_name);
            $attachment = "support_ticket_attachments/" . $attachment_name;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('ADMIN_URL').'/api/upload/support/ticket/file',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'attachment'=> new CURLFile(public_path($attachment))
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }

        DB::table('support_messages')->insert([
            'support_ticket_id' => $request->support_ticket_id,
            'sender_id' => Auth::user()->id,
            'sender_type' => 2,
            'message' => $request->message,
            'attachment' => $attachment,
            'created_at' => Carbon::now()
        ]);

        Toastr::success('Message Sent');
        return back();
    }
}
