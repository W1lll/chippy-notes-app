describe('Login Page', () => {
  it('Page loads', () => {
    cy.visit('http://localhost/hackcamp/login.php')
  })

  it('Logs in', () => {
    cy.visit('http://localhost/hackcamp/login.php')
    cy.get('[data-test-id="username"]').type('will')
    cy.get('[data-test-id="password"]').type('will')
    cy.get('[data-test-id="login"]').click()

    cy.url().should('include', 'index.php')
  })

  it('Registers', () => {
    let username = `${Math.random().toString(36).slice(2)}test`
    let password = 'password1234'
    cy.visit('http://localhost/hackcamp/login.php')
    cy.get('[data-test-id="new_username"]').type(username)
    cy.get('[data-test-id="new_password"]').type(password)
    cy.get('[data-test-id="register"]').click()

    cy.login(username, password).then((response) => {
    })
  })
})

describe('Notes Page', () => {
  it('Page loads', () => {
    cy.login('will', 'will').then((response) => {
      cy.visit('http://localhost/hackcamp/index.php')
    })
  })

  it('Creates a new note', () => {
    let newText = `${Math.random().toString(36).slice(2)}`
    cy.login('will', 'will').then(response => response.data)
    .then((data) => {

      cy.getNotes(data.UserID).then(response => {
        let pre = response.data.length

        cy.visit('http://localhost/hackcamp/index.php')
        cy.get('[data-test-id="new-note-input"]').type(newText)
        cy.get('[data-test-id="submit-note"]').click()

        cy.getNotes(data.UserID).then(response => response.data)
        .then((data) => {
          expect(data.length).to.be.greaterThan(pre);
        })
      })
    })
  })

  it('Updates an existing note', () => {
    let newText = `${Math.random().toString(36).slice(2)}`
    cy.login('will', 'will').then(response => response.data)
    .then((data) => {

      cy.getNotes(data.UserID).then(response => {
        cy.visit('http://localhost/hackcamp/index.php')
        cy.get('.note-link').last().click()

        cy.get('[data-test-id="new-note-input"]').type(newText)
        cy.get('[data-test-id="submit-note"]').click()

        cy.getNotes(data.UserID).then(response => response.data)
        .then((data) => {
          let dataArray = data.splice(-1)[0].Content
          dataArray = dataArray.split('<br/>')
          expect(dataArray).includes(newText);
        })
      })
    })
  })
})