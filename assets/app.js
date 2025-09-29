/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import "react-datepicker/dist/react-datepicker.css";

import React from 'react';
import { createRoot } from 'react-dom/client';
import BookingForm from "./components/BookingForm";

const rootElement = document.getElementById('react-root');
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<BookingForm />);
}
