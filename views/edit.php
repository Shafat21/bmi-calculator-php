<?php
require_once '../includes/auth.php'; // Ensure user is authenticated
require_once '../includes/db.php';
require '../includes/header.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM BMIRecords WHERE RecordID = ? AND BMIUserID = ?");
    $stmt->execute([$id, $_SESSION['bmi_user_id']]);
    $record = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $height = filter_var($_POST['height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $weight = filter_var($_POST['weight'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $bmi = $weight / (($height / 100) ** 2);

        $updateStmt = $pdo->prepare("UPDATE BMIRecords SET Height = ?, Weight = ?, BMI = ? WHERE RecordID = ?");
        $updateStmt->execute([$height, $weight, $bmi, $id]);

        echo "<script>Swal.fire('Success', 'Record updated successfully.', 'success');</script>";
        header("Location: history.php");
        exit();
    }
} else {
    header("Location: history.php");
    exit();
}
?>

<div class="min-h-screen flex items-center justify-center bg-gray-900 text-white">
    <div class="max-w-md w-full bg-gray-800 p-8 rounded-lg shadow-lg">
        <h2 class="text-center text-3xl font-extrabold text-gray-100 mb-6">Edit BMI Record</h2>
        <form class="space-y-6" action="edit.php?id=<?php echo $id; ?>" method="POST">
            <div class="rounded-md shadow-sm">
                <div class="mb-4">
                    <label for="height" class="sr-only">Height (cm)</label>
                    <input id="height" name="height" type="number" step="0.01" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="<?php echo htmlspecialchars($record['Height']); ?>" placeholder="Height (cm)">
                </div>
                <div class="mb-4">
                    <label for="weight" class="sr-only">Weight (kg)</label>
                    <input id="weight" name="weight" type="number" step="0.01" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="<?php echo htmlspecialchars($record['Weight']); ?>" placeholder="Weight (kg)">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Record
                </button>
            </div>
        </form>
    </div>
</div>

<?php require '../includes/footer.php'; ?>
