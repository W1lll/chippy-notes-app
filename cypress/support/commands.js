// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

import axios from 'axios';

Cypress.Commands.add('login', (username, password) => {
    const data = new URLSearchParams();
    data.append('username', username);
    data.append('password', password);
    data.append('action', 'login');

    return axios({
        url: `http://localhost/hackcamp/login.php`,
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        data: data
    }).then((response) => {
        return response;
    });
});


Cypress.Commands.add('getNotes', (Id) => {
    return axios({
        url: `http://localhost/hackcamp/getNoteContent.php?userId=${Id}`,
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then((response) => {
        return response;
    });
});
