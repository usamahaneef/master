<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use PDF;
use Illuminate\Queue\SerializesModels;

class DietPlanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;

    public function __construct($plan)
    {
        $this->plan = $plan;
    }

    public function build()
    {
        $pdf = PDF::loadView('admin.sections.emails.send-diet-plan', ['plan' => $this->plan]);

        return $this->view('admin.sections.emails.send-diet-plan')
            ->attachData($pdf->output(), 'diet_plan.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
