/// <reference types="cypress" />

describe('Prueba el formulario de contacto', () => {
    it('Prueba de la pagina de contacto y el envio de email', () => {
        cy.visit('/contacto');

        cy.get('[data-cy="heading-contacto"]').should('exist');
        cy.get('[data-cy="heading-contacto"]').invoke('text').should('equal', 'Contacto');
        cy.get('[data-cy="heading-contacto"]').invoke('text').should('not.equal', 'Formulario Contacto');
        
        cy.get('[data-cy="heading-formulario"]').should('exist');
        cy.get('[data-cy="heading-formulario"]').invoke('text').should('equal', 'Llene el formulario del contacto');
        cy.get('[data-cy="heading-formulario"]').invoke('text').should('not.equal', 'Llena el formulario');
    });

    it('Llena los campos del formulario', () => {
        cy.get('[data-cy="input-nombre"]').type('Guille');
        cy.get('[data-cy="input-mensaje"]').type('Deseo comprar una casa');
        cy.get('[data-cy="input-opciones"]').select('Comprar');
        cy.get('[data-cy="input-precio"]').type('120000');
        cy.get('[data-cy="forma-contacto"]').eq(1).check();

        cy.wait(3000);

        cy.get('[data-cy="forma-contacto"]').eq(0).check();
        cy.get('[data-cy="input-telefono"]').type('12312312');

        cy.get('[data-cy="input-fecha"]').type('2022-05-07');
        cy.get('[data-cy="input-hora"]').type('12:30');

        cy.get('[data-cy="formulario-contacto"]').submit();
        cy.get('[data-cy="alerta-envio-formulario"]').should('exist');
        cy.get('[data-cy="alerta-envio-formulario"]').invoke('text').should('equal', ' Mensaje enviado correctamente ');

        cy.get('[data-cy="alerta-envio-formulario"]').should('have.class','alerta').and('have.class', 'exito').and('not.have.class', 'error');
    });
});