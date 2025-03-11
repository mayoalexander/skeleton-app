describe("Recipe Search", () => {
    beforeEach(() => {
        cy.viewport(1024, 768);
        cy.visit("http://localhost:3000"); // Go to homepage before each test
    });

    // ✅ Pagination should retain search parameters
    it("Retains search parameters when paginating", () => {
        cy.get(".utility-input")
            .should("exist")
            .eq(0)
            .type("vol") // test string to pull paginated results
            .wait(1500);

        cy.get(".pagination-next").should("exist").click(); // Click 'Next' Page

        cy.url().should("include", "keyword=vol"); // Ensure URL contains search term
        cy.get(".recipe-list-item h2").should(
            "contain",
            "Chocolate Chip Cookies"
        );
    });

    // ✅ Recipe links should go to details page
    it("Navigates to recipe details page", () => {
        cy.get(".utility-input")
            .should("exist")
            .eq(0)
            .type("Salmon")
            .wait(1500);

        cy.get(".recipe-list-item a").first().click(); // Click first recipe link

        cy.url().should("match", /\/recipes\/[a-z0-9-]+$/); // URL should contain slug
        cy.get(".recipe-details h1").should("be.visible"); // Recipe name should be visible
    });

    // ✅ Recipe details page should display all data
    it("Displays all required details on recipe page", () => {
        cy.get(".utility-input")
            .should("exist")
            .eq(0)
            .type("Salmon")
            .wait(1500);

        cy.get(".recipe-list-item a").first().click(); // Click first recipe link

        cy.url().should("match", /\/recipes\/[a-z0-9-]+$/); // Ensure slug format
        cy.get(".recipe-details h1").should("be.visible"); // Check recipe name
        cy.get(".recipe-author").should("contain", "@wildalaskan.com"); // Check author
        cy.get(".recipe-description").should("be.visible"); // Check description
        cy.get(".recipe-ingredients li").should("have.length.greaterThan", 0); // Ingredients list
        cy.get(".recipe-steps li").should("have.length.greaterThan", 0); // Steps list
    });
});
