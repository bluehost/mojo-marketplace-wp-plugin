function mm_load_revisions() {
	jQuery( document ).ready( function ( $ ) {
		$( '.staging-revision' ).remove();
		$( '#staging-revisions-loader' ).fadeIn();
		var revisions_data = {
			'action': 'mm_revisions'
		}
		$.post( ajaxurl, revisions_data, function( revisions ) {
			$( '#staging-revisions-loader' ).fadeOut( 'slow', function() {
				$( '#staging-revisions-loader' ).after( revisions );
				$( '.staging-revision' ).fadeIn( 'slow' );
			} );
		} );
	} );
}
jQuery( document ).ready( function ( $ ) {
	$( '#staging-revisions-loader img' ).ready( function() {
		mm_load_revisions();
	} );
	$( 'body' ).on( 'click', '.mm-close-modal', function() {
		$( '#mm-modal-wrap' ).fadeOut( 'slow', function() {
			$( '#mm-modal-wrap' ).remove();
		} );
	} );
	$( 'body' ).on( 'click', '.mm-modal', function () {
		if ( typeof $( this ).data( 'mm-modal' ) !== 'undefined' ) {
			var modal_data = {
				'action': 'mm_modal',
				'template': $( this ).data( 'mm-modal' )
			}
			$.post( ajaxurl, modal_data, function( modal_content ) {
				$( '#mojo-wrapper' ).append( modal_content );
				$( '#mm-modal-wrap' ).fadeIn( 'slow' );
			} );
		}
	} );

	$( 'body' ).on( 'click', '.staging-action', function() {
		if ( typeof $( this ).data( 'interim' ) !== 'undefined' ) {
			var interim_data = {
				'action': 'mm_interim',
				'template': $( this ).data( 'interim' )
			}
			$.post( ajaxurl, interim_data, function( interim_content ) {
				$( '#main' ).fadeOut( 'slow', function() {
					$( '#main' ).html( interim_content );
					$( '#main' ).fadeIn( 'slow' );
				} );
			} );
		}
		$( this ).append( ' <img class="staging-action-loader" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMjBweCcgaGVpZ2h0PScyMHB4JyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWlkWU1pZCIgY2xhc3M9InVpbC1yaW5nIj48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIGZpbGw9Im5vbmUiIGNsYXNzPSJiayI+PC9yZWN0PjxjaXJjbGUgY3g9IjUwIiBjeT0iNTAiIHI9IjQ1IiBzdHJva2UtZGFzaGFycmF5PSIxNjkuNjQ2MDAzMjkzODQ4ODIgMTEzLjA5NzMzNTUyOTIzMjU3IiBzdHJva2U9IiNmZmYiIGZpbGw9Im5vbmUiIHN0cm9rZS13aWR0aD0iNSI+PGFuaW1hdGVUcmFuc2Zvcm0gYXR0cmlidXRlTmFtZT0idHJhbnNmb3JtIiB0eXBlPSJyb3RhdGUiIHZhbHVlcz0iMCA1MCA1MDsxODAgNTAgNTA7MzYwIDUwIDUwOyIga2V5VGltZXM9IjA7MC41OzEiIGR1cj0iMS44cyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIGJlZ2luPSIwcyI+PC9hbmltYXRlVHJhbnNmb3JtPjwvY2lyY2xlPjwvc3ZnPg=="/>' );
		$( '.staging-action' ).prop( 'disabled', true );
		var data = {
			'action': $( this ).data( 'staging-action' )
		};

		if ( typeof $( this ).data( 'staging-param1' ) !== 'undefined' ) {
			var extra_params = {
				'param1' : $( this ).data( 'staging-param1' )
			}
			$.extend( data, extra_params );
		}

		$.post( ajaxurl, data, function( response ) {

			try {
				response = JSON.parse( response );
			} catch (e) {
				response = {status:"error", message:"Invalid JSON response."};
			}

			if ( typeof response.callback !== 'undefined' ) {
				window[ response.callback ]();
			}

			if ( typeof response.status == 'undefined' ) {
				response = {status:"error", message:"Unable to make the request."};
			}

			if ( response.status == 'error' && typeof response.message !== 'undefined' ) {
				$( '#mojo-wrapper' ).append( '<div id="mm-message" class="mm-error" style="display:none;">' + response.message + '</div>' );
				$( '#mm-message' ).fadeIn( 'slow', function() {
					setTimeout( function() {
						$( '#mm-message' ).fadeOut( 'fast', function() {
							$( '#mm-message' ).remove();
						} );
					}, 8000 );
				} );
			}

			if ( typeof response.load_page !== 'undefined' ) {
				window.location = response.load_page
			}

			if ( typeof response.new_tab !== 'undefined' ) {
				var new_tab = window.open( response.new_tab, '_blank' );
				new_tab.focus();
			}

			if ( typeof response.reload !== 'undefined' && response.reload == 'true' ) {
				window.location = window.location;
			}

			if ( response.status == 'success' && typeof response.message !== 'undefined' ) {
				$( '#mojo-wrapper' ).append( '<div id="mm-message" class="mm-success" style="display:none;">' + response.message + '</div>' );
				$( '#mm-message' ).fadeIn( 'slow', function() {
					setTimeout( function() {
						$( '#mm-message' ).fadeOut( 'fast', function() {
							$( '#mm-message' ).remove();
						} );
					}, 8000 );
				} );
			}

			$( '.staging-action' ).prop( 'disabled',false );
			$( '.staging-action-loader' ).remove();
			$( '#mm-modal-wrap' ).remove();
		} );
	} );
} );
