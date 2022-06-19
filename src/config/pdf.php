<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
  'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
  'useKashida' => 75,  
  'font_path' => __DIR__.'/resources/fonts/',
	'font_data' => [
		'arial' => [
			'R'  => '../public/assets/arial.ttf',    // regular font
			'B'  => '../public/assets/arial.ttf',       // optional: bold font
			'I'  => '../public/assets/arial.ttf',     // optional: italic font
			'BI' => '../public/assets/arial.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
      ],
		'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
		'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		// ...add as many as you want.
	]
	// ...
];
