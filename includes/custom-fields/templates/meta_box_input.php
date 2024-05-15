<?php

JOBCIRCLE_CFS()->form->load_assets();

echo JOBCIRCLE_CFS()->form( [
    'post_id'       => $post->ID,
    'field_groups'  => $metabox['args']['group_id'],
    'front_end'     => false,
] );
