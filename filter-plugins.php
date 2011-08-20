<?php
/*
Plugin Name: Filter Plugins
Description: Filter plugins by their author.
Author: scribu
Author URI: http://scribu.net
Plugin URI: http://wordpress.org/extend/plugins/filter-plugins/
Version: 1.0
*/

class Filter_Plugins {

	function plugin_row_meta( $meta, $file, $data ) {
		if ( empty( $meta ) )
			$meta[] = '';

		$meta[ key( $meta ) ] .= '<span class="pba-id" data-author="' . esc_attr( $data['Author'] ) . '" style="display:none"></span>';
		return $meta;
	}

	function admin_footer() {
		$screen = get_current_screen();

		if ( !in_array( $screen->base, array( 'plugins', 'plugins-network' ) ) )
			return;
?>
		<script type="text/javascript">
(function($){
	var $select = $('<select>').append( $('<option>').html('&mdash; Author &mdash;') );

	var authors = [];
	$('.pba-id').each(function(){
		var author = $(this).attr('data-author');
		if ( -1 == $.inArray( author, authors ) )
			authors.push(author);
	});

	$.each(authors, function(i, author){
		$select.append( $('<option>').html(author) );
	});

	$select.change(function(){
		var selector = '.pba-id[data-author="' + $(this).val() + '"]';

		$('#the-list tr').each(function(){
			var $row = $(this);

			if ( $row.find(selector).length )
				$row.show();
			else
				$row.hide();
		});
	});

	$select.insertBefore('.top .tablenav-pages');
}(jQuery));
		</script>
<?php
	}
}

add_filter( 'plugin_row_meta',  array( 'Filter_Plugins', 'plugin_row_meta' ), 10, 3 );
add_filter( 'admin_footer',  array( 'Filter_Plugins', 'admin_footer' ) );

