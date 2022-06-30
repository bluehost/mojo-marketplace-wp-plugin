import App from './app';
import domReady from '@wordpress/dom-ready';
import { render } from '@wordpress/element';

domReady(
	() => {
		return render(<App />, document.getElementById('mojo-marketplace-app'));
	}
);
