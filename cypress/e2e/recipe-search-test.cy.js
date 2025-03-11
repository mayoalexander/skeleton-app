describe("Recipe Search", () => {
    beforeEach(() => {
        cy.viewport(1024, 768);
        cy.visit("http://localhost:3000"); // Go to homepage before each test
    });

    it("Displays the correct page title", () => {
        cy.get("h1").should("contain", "Recipe Search 3000");
    });

    // it("Returns an error message when searching with no input", () => {
    //     cy.get(".search-button").click();
    //     cy.contains("At least one search parameter is required").should(
    //         "be.visible"
    //     );
    // });

    it("Searches by keyword and returns a matching recipe", () => {
        cy.get(".utility-input")
            .should("exist")
            .eq(0)
            .type("Chicken").wait(1500);

        cy.get(".recipe-list-item h2").should(
            "contain",
            "Garlic Butter Chicken"
        );
        
    });

    it("Searches by author email and returns the expected recipe", () => {
        cy.get(".utility-input")
            .should("exist")
            .eq(1)
            .type("johndoe@wildalaskan.com")
            .wait(1500);

        cy.get(".recipe-list-item h2").should("contain", "Wild Salmon Caesar Salad");
    });

    it("Searches by ingredient and returns the expected recipe", () => {
        cy.get(".utility-input")
            .should("exist")
            .eq(2)
            .type("olive")
            .wait(1500);

        cy.get(".recipe-list-item h2").should("contain", "Caesar Salad");
    });

    it("Searches by ingredient and returns the expected recipe by selectors", () => {
        cy.get(".ingredient-selectors .ingredient-item")
            .should("exist")
            .eq(1)
            .click();
        cy.get(".ingredient-selectors .ingredient-item")
            .should("exist")
            .eq(2)
            .click();

        cy.get(".recipe-list-item h2").should("contain", "Garlic");
    });

    it("Handles no results gracefully", () => {
        cy.get(".utility-input").should("exist").eq(2).type("magicRecipieThatDoesntExist").wait(1500);

        cy.get(".recipe-list li").should("not.exist");
        cy.contains("No results found").should("be.visible");
    });
});
