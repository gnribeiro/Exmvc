<?php

return array(
    'gallery'=>array(
      array(
        'name'       => 'location',
        'blockTitle' => 'Gallery Location',
        'fields'     => array(
          array(
              'name'       => 'location',
              'labelTitle' => 'Location',
              'fieldType'  => 'textField',
          ),
          array(
             'name'       => 'map',
             'labelTitle' => 'Link to a map',
             'fieldType'  => 'textField',
          )
        )
      ),

      array(
        'name'        => 'other',
        'blockTitle'  => 'Other details',
        'fields'      => array(
          array(
              'name'       => 'website',
              'labelTitle' => 'Website address',
              'fieldType'  => 'textField'
          )
        )
      )
    ),
    


);