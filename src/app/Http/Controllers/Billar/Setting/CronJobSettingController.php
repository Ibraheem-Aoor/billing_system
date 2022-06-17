<?php
	
	namespace App\Http\Controllers\Billar\Setting;
	
	use App\Http\Controllers\Controller;
	
	class CronJobSettingController extends Controller
	{
		public function index(): array
		{
			$php_path = exec("which php");
			$command = base_path() . '/artisan schedule:run >> /dev/null 2>&1';
			$cpanel_command = exec("which php") . ' ' . base_path() . '/artisan schedule:run >> /dev/null 2>&1';
			return [
				'php_path' => $php_path,
				'cpanel_command' => $cpanel_command,
				'command' => $command,
				'symlink_command' => $this->cronjobSymlink(),
			];
		}
		
		public function cronjobSymlink(): string
		{
			$value = $this->laravel['config']['filesystems.links'] ??
				[public_path('storage') => storage_path('app/public')];
			$link = array_key_first($value);
			$target = array_values($value)[0];
			return 'ln -s ' . $target . ' ' . $link;
		}
		
		
	}
