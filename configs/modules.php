<?php

/**
 * Returns an array of modules and services.
 *
 * @since 1.1.0
 */
return array(
	/*
	 |-------------------------------------------------------------------------
	 | Base configs, to setting up this plugin.
	 |-------------------------------------------------------------------------
	 */
	\TBI\Core\Enqueue::class,
	\TBI\Core\ActionLink::class,
	
	/*
	 |-------------------------------------------------------------------------
	 | Admin configs, to implement admin dashboard of plugin.
	 |-------------------------------------------------------------------------
	 */
	\TBI\Core\Dashboard::class,
	
	/*
	 |-------------------------------------------------------------------------
	 | Services configs, to implement all services of plugin.
	 |-------------------------------------------------------------------------
	 */
	\TBI\Services\BookCPT::class
);
