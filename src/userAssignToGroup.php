<?php namespace SuperAdmin;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class userAssignToGroup extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;
	public $input  = [];

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($input)
	{
		$this->input = $input;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$efront  = new App\Dalata\Repositories\EfrontApiRepository;
		$result = json_decode($efront->AddUserToGroup($this->input['efront_user_id'],$this->input['efront_group_id']));
	}

}