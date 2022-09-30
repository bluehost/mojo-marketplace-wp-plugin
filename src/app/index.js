import './stylesheet.scss';

import apiFetch from '@wordpress/api-fetch';
import classnames from 'classnames';
import { useEffect } from 'react';
import { useState } from '@wordpress/element';
import { HashRouter as Router, useLocation, useNavigate } from 'react-router-dom';


import { Button, Card, CardBody, CardHeader, CardFooter, CardMedia, TabPanel, Spinner } from '@wordpress/components';

import Marketplace from '../../vendor/newfold-labs/wp-module-marketplace/components/marketplace/index.js';

export const App = () => {
	return (
		<Router>
			<div className="mojo-app">
				<Marketplace
					Components={
						{
							Button,
							Card,
							CardBody,
							CardFooter,
							CardHeader,
							CardMedia,
							TabPanel,
							Spinner
						}
					}
					constants={
						{
							'resturl': window.mojo.restUrl,
							'eventendpoint': '/newfold-data/v1/events/',
							'perPage': 12,
							'supportsCTB': false,
						}
					}
					methods={
						{
							apiFetch,
							classnames,
							useEffect,
							useState,
							useNavigate,
							useLocation
						}
					}
				/>
			</div>
		</Router>
	);
}

export default App;
