<?php

use TBI\Core\ActionLink;
use TBI\Core\Dashboard;
use TBI\Core\Enqueue;

return array(
	/*
	 |-------------------------------------------------------------------------
	 | Base configs, For setting up this plugin.
	 |-------------------------------------------------------------------------
	 */
	Enqueue::class,
	ActionLink::class,
	
	/*
	 |-------------------------------------------------------------------------
	 | Admin configs, For implement admin dashboard of plugin.
	 |-------------------------------------------------------------------------
	 */
	Dashboard::class,
);
