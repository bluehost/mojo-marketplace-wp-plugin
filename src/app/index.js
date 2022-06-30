import './stylesheet.scss';

import apiFetch from '@wordpress/api-fetch';
import classnames from 'classnames';
import { useEffect } from 'react';
import { useState } from '@wordpress/element';

import { Button, Card, CardBody, CardHeader, CardFooter, CardMedia, TabPanel, Spinner } from '@wordpress/components';

import Marketplace from '../../vendor/newfold-labs/wp-module-marketplace/components/marketplace/index.js';

export const App = () => {
	return (
		<div className="wppw">
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
					}
				}
			/>
		</div>
	);
}

export default App;
