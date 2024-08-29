<!-- calculate_form.php -->
<div class="min-h-screen flex items-center justify-center bg-gray-900 text-white">
    <div class="max-w-md w-full bg-gray-800 p-8 rounded-lg shadow-lg">
        <h2 class="text-center text-3xl font-extrabold text-gray-100 mb-6">
            BMI Calculator
        </h2>
        <form class="space-y-6" action="index.php" method="POST">
            <div class="rounded-md shadow-sm">
                <div class="mb-4">
                    <label for="height" class="sr-only">Height (cm)</label>
                    <input id="height" name="height" type="number" step="0.01" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Height (cm)">
                </div>
                <div class="mb-4">
                    <label for="weight" class="sr-only">Weight (kg)</label>
                    <input id="weight" name="weight" type="number" step="0.01" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Weight (kg)">
                </div>
                <div class="mb-4">
                    <label for="age" class="sr-only">Age</label>
                    <input id="age" name="age" type="number" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Age">
                </div>
                <div class="mb-4">
                    <label for="sex" class="sr-only">Sex</label>
                    <select id="sex" name="sex" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                        <option value="o">Other</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="waist" class="sr-only">Waist (cm)</label>
                    <input id="waist" name="waist" type="number" step="0.01" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Waist (cm)">
                </div>
                <div class="mb-4">
                    <label for="hip" class="sr-only">Hip (cm)</label>
                    <input id="hip" name="hip" type="number" step="0.01" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Hip (cm)">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Calculate BMI
                </button>
            </div>
        </form>
    </div>
</div>
