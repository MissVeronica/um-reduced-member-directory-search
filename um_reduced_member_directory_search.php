<?php
/**
 * Plugin Name:      Ultimate Member - Reduced Member Directory Search
 * Description:      Extension to Ultimate Member for Reducing Member Directory Search excluding all fields with meta_key names containing email.
 * Version:          1.0.0
 * Requires PHP:     7.4
 * Author:           Miss Veronica
 * License:          GPL v2 or later
 * License URI:      https://www.gnu.org/licenses/gpl-2.0.html
 * Author URI:       https://github.com/MissVeronica
 * Text Domain:      ultimate-member
 * Domain Path:      /languages
 * UM version:       2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'UM' ) ) return;

class UM_Reduce_Member_Directory_Search {

    function __construct( ) {

        add_filter( 'users_pre_query',       array( $this, 'users_pre_query_reduce_um_search' ), 10, 2 );
        add_filter( 'um_settings_structure', array( $this, 'um_settings_structure_reduce_um_search' ), 10, 1 );
    }

    function users_pre_query_reduce_um_search( $null, $current ) {

        $contents = explode( "OR", $current->query_where );
        foreach( $contents as $key => $value ) {
            if( strpos( $value, 'email' ) !== false ) unset( $contents[$key] );
        }
        $current->query_where = implode( "OR" , $contents );

        $removes = array( 'email' );
        $reduce_um_search_fields = UM()->options()->get( 'reduce_um_search_fields' );
        if( !empty( $reduce_um_search_fields )) {
            $reduce_um_search_fields = array_map( 'trim', explode( ',', strtolower( $reduce_um_search_fields )));
            $removes = array_merge( $removes, $reduce_um_search_fields );
        }
        
        $contents = explode( ",", $current->query_from );
        foreach( $contents as $key => $value ) {
            foreach( $removes as $remove ) {
                if( strpos( $value, $remove ) !== false ) unset( $contents[$key] );
            }
        }
        $current->query_from = implode( "," , $contents );

        return null;
    }

    function um_settings_structure_reduce_um_search( $settings ) {

        $settings['']['sections']['users']['fields'][] = array(
            'id'      => 'reduce_um_search_fields',
            'type'    => 'text',
            'label'   => __( 'Additional Fields for reduced Member Directory Search ', 'ultimate-member' ),
            'tooltip' => __( 'Enter meta_keys (comma separated) to exclude from the Search. All meta_keys with email names are excluded by default.', 'ultimate-member' ),
            'size'    => 'medium'
        );   

        return $settings;
    }
}

new UM_Reduce_Member_Directory_Search();
