Feature: Gestión de reservas en la aplicación

  Scenario: Ver la lista de mis reservas
    Given que soy un usuario autenticado
    When voy a la página de mis reservas
    Then debería ver la lista de mis reservas

   