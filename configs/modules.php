<?php

/**
 * Returns an array of modules and services.
 *
 * @since 1.0.0
 */

return array(
	/*
	 |-------------------------------------------------------------------------
	 | Base configs, to setting up this plugin.
	 |-------------------------------------------------------------------------
	 */
	\TBI\Core\Enqueue::class, // @since 1.0.0
	\TBI\Core\ActionLink::class, // @since 1.0.1
	
	/*
	 |-------------------------------------------------------------------------
	 | Admin configs, to implement admin dashboard of plugin.
	 |-------------------------------------------------------------------------
	 */
	\TBI\Core\Dashboard::class, // @since 1.0.0
	
	/*
	 |-------------------------------------------------------------------------
	 | Services configs, to implement all services of plugin.
	 |-------------------------------------------------------------------------
	 */
	\TBI\Services\BookCPT::class, // @since 1.2.0
	\TBI\Services\LikeDislike::class // @since 1.4.0
);
