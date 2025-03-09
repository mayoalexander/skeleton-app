INSERT INTO recipes (name, description, ingredients, steps, email, slug, created_at, updated_at)
VALUES (
    'Test Recipe',
    'This is a test recipe.',
    '["ingredient1", "ingredient2"]',
    '["Step 1", "Step 2"]',
    'test@example.com',
    'test-recipe',
    NOW(),
    NOW()
);