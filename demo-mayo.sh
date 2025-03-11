#!/bin/bash
set -e

# Define some colors for flair.
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

echo -e "${CYAN}Welcome to the Demo Mayo Show! Let's whip up some magic!${NC}"

# Step 1: Reset the environment
echo -e "${YELLOW}\nStep 1: Resetting the environment...${NC}"
echo "Clearing cache... (Out with the old, in with the new!)"
./vendor/bin/sail artisan cache:clear && echo "Cache cleared!"
echo "Wiping out stale configurations..."
./vendor/bin/sail artisan config:clear && echo "Configurations cleared!"
echo "Refreshing the database with a fresh seed!"
./vendor/bin/sail artisan migrate:fresh --seed && echo "Database migrated and seeded. Fresh as a daisy!"

# Step 2: Index the recipe content data
echo -e "${YELLOW}\nStep 2: Indexing the recipe content data...${NC}"
echo "Flushing out the old recipe index..."
./vendor/bin/sail artisan scout:flush "App\Models\Recipe" && echo "Old recipe index flushed!"
echo "Importing the latest recipes... Bon Appétit!"
./vendor/bin/sail artisan scout:import "App\Models\Recipe" && echo "Recipes imported successfully!"

# Step 3: Run backend tests
echo -e "${YELLOW}\nStep 3: Running backend tests...${NC}"
echo "Putting the backend under the test spotlight..."
./vendor/bin/sail artisan test && echo "Backend tests passed with flying colors!"

# Step 4: Kickstart the Nuxt frontend
echo -e "${YELLOW}\nStep 4: Setting up the Nuxt frontend...${NC}"
echo "Installing Nuxt dependencies—preparing for a frontend feast!"
./vendor/bin/sail npm install --prefix frontend && echo "Nuxt dependencies installed!"

# Step 5: Run the frontend
echo -e "${YELLOW}\nStep 5: Launching the frontend...${NC}"
echo "Firing up the frontend server. Enjoy the view!"
./vendor/bin/sail npm run dev --prefix frontend &

# Optional: Deploy to staging environment (if needed)
# echo -e "${YELLOW}\nOptional: Deploying to staging...${NC}"
# npm run deploy:staging && echo "Deployed to staging!"

# Step 6: Run Cypress tests in the UI
echo -e "${YELLOW}\nStep 6: Running Cypress tests...${NC}"
echo "Installing Cypress—time to get testy!"
npm run cypress:install && echo "Cypress installed!"
echo "Opening the Cypress UI. Let the testing begin!"
npm run cypress:open && echo "Cypress UI is open!"

open http://localhost:3000/

echo -e "${GREEN}\nDemo Mayo process complete! Bon Appétit!!${NC}"
