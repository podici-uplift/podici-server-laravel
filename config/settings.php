<?php

return [
    'media' => [
        'upload' => [
            'allowed_types' => [],
            'min_size' => 24, // 24kb
            'max_size' => 4 * 1024, // 4mb
        ],
        'temporary_local_url_lifetime' => 60 * 5, // 5minutes
    ],

    'reviews' => [
        'max_no_of_pins' => 3,
    ],

    'user' => [
        /**
         * The cooldown period for updating username (in days)
         *
         * Set to 0 to disable
         */
        'username_update_cooldown' => 183,
    ],

    'shop' => [
        'name_length_limit' => 64,
        /**
         * The cooldown period for updating name (in days)
         *
         * Set to 0 to disable
         */
        'name_update_cooldown' => 183,
    ],

    /**
     * The age at which a user is regarded an adult
     *
     * Set to 0 to disable
     */
    'adult_age' => 18,

    /**
     * If to verify the old password when updating a password
     */
    'password_update_requires_old_password' => true,

    /**
     * If to enable the tracking of updates to selected models
     */
    'tracking_model_updates' => true,

    /**
     * If to enable the tracking of views
     */
    'tracking_views' => true,
];
