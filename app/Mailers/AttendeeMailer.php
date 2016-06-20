<?php

namespace App\Mailers;

use App\Models\Attendee;
use App\Models\Message;
use App\Models\Order;
use Carbon\Carbon;
use Mail;
use Log;


class AttendeeMailer extends Mailer
{

    public function sendAttendeeTicket($attendee)
    {

        Log::info("Sending ticket to: " . $attendee->email);

        $data = [
            'attendee' => $attendee,
        ];

        Mail::send('Mailers.TicketMailer.SendAttendeeTicket', $data, function ($message) use ($attendee) {
            $message->to($attendee->email);
            $message->subject('Your ticket for the event ' . $attendee->order->event->title);

            $file_name = $attendee->reference;
            $file_path = public_path(config('attendize.event_pdf_tickets_path')) . '/' . $file_name . '.pdf';

            $message->attach($file_path);
        });

    }

    /**
     * Sends the attendees a message
     *
     * @param Message $message_object
     */
    public function sendMessageToAttendees(Message $message_object)
    {
        $event = $message_object->event;

        $attendees = ($message_object->recipients == 'all')
            ? $event->attendees // all attendees
            : Attendee::where('ticket_id', '=', $message_object->recipients)->where('account_id', '=',
                $message_object->account_id)->get();

        foreach ($attendees as $attendee) {

            $data = [
                'attendee'        => $attendee,
                'event'           => $event,
                'message_content' => $message_object->message,
                'subject'         => $message_object->subject,
                'email_logo'      => $attendee->event->organiser->full_logo_path,
            ];

            Mail::send('Emails.messageAttendees', $data, function ($message) use ($attendee, $data) {
                $message->to($attendee->email, $attendee->full_name)
                    ->from(config('attendize.outgoing_email_noreply'), $attendee->event->organiser->name)
                    ->replyTo($attendee->event->organiser->email, $attendee->event->organiser->name)
                    ->subject($data['subject']);
            });
        }

        $message_object->is_sent = 1;
        $message_object->sent_at = Carbon::now();
        $message_object->save();
    }

    public function SendAttendeeInvite($attendee)
    {

        Log::info("Sending invite to: " . $attendee->email);

        Mail::queue([], [], function ($message) use ($attendee) {
            $message->to($attendee->email);

            $subject = 'Your ticket for the event ' . $attendee->order->event->title;
            if ($attendee->event->invitation_mail_subject != null || $attendee->event->invitation_mail_subject != '') {
              $subject = $attendee->event->invitation_mail_subject;
            }

            $message->subject($subject);

            $file_name = $attendee->getReferenceAttribute();
            $file_path = public_path(config('attendize.event_pdf_tickets_path')) . '/' . $file_name . '.pdf';

            $message->attach($file_path);

            $data = [
              'attendee' => $attendee,
            ];

            $content = "";
            if ($attendee->event->invitation_model_id != null) {
              $path = $attendee->event->model->html->path();
              $content = view()->file($path, $data);
            }
            else {
              $content = view('Mailers.TicketMailer.SendAttendeeInvite', $data);
            }
            

            $message->setBody($content, 'text/html');
        });

    }


}
