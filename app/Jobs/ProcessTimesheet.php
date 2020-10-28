<?php

namespace App\Jobs;

use App\Gamify\Points\TimesheetAdded;
use App\Timesheet;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Webkul\Customer\Models\Customer;
use Illuminate\Support\Facades\Hash;

class ProcessTimesheet implements ShouldQueue
//class ProcessTimesheet
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
//    use Dispatchable, SerializesModels;

    protected $timesheet;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->timesheet->processed) {
            $client = new Client(['max_retry_attempts' => 5, 'verify' => false]);
//            $response = $client->get(env("CANDIDATE_API"), ['query' => ['id' => $this->timesheet->employee_id]]);
            $response = $client->get(route('employee', ['employee' => $this->timesheet->employee_id]));
            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody()->getContents())->data;
                if (property_exists($response, 'firstName')) {

                    $customer = Customer::firstOrCreate([
                        'employee_id' => $response->id,
                    ]);

                    $customer->first_name = $response->firstName;
                    $customer->last_name = $response->lastName;
                    $customer->email = $response->email;
                    $customer->phone = $response->cellPhone;

                    if (!$customer->password) {
                        // Random password in case no cell phone number is set
                        $phonePassword = 'M2hdvMDx5HXQUJSlMieD1SUEKWB/Sq3UuZu7q95sQqVRzqV12';
                        if ($customer->phone) {
                            // Update customer password to their phone number (one time)
                            $phonePassword = ltrim(str_replace('-', '', $customer->phone), '1');
                        }
                        $customer->password = Hash::make($phonePassword);
                    }
                    $customer->is_verified = true;

                    $customer->save();

                    $customer->givePoint(new TimesheetAdded($this->timesheet));

                    $this->timesheet->processed = true;
                    $this->timesheet->update();
                }
            }
        }
    }
}
