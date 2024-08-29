<?php
require_once '../includes/auth.php'; // Ensure user is authenticated
require_once '../includes/db.php';   // Include the database connection
require '../includes/header.php';    // Include the header with the title and buttons

// Fetch the BMI records for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM BMIRecords WHERE BMIUserID = ?");
$stmt->execute([$_SESSION['bmi_user_id']]);
$records = $stmt->fetchAll();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] == 'delete') {
        // Delete the record
        $deleteStmt = $pdo->prepare("DELETE FROM BMIRecords WHERE RecordID = ? AND BMIUserID = ?");
        $deleteStmt->execute([$id, $_SESSION['bmi_user_id']]);
        header("Location: history.php");
        exit();
    } elseif ($_GET['action'] == 'edit') {
        // Redirect to edit page (assuming edit.php handles editing)
        header("Location: edit.php?id=" . $id);
        exit();
    }
}
?>

<div class="min-h-screen flex flex-col items-center bg-gray-900 text-white">
    <div class="max-w-4xl w-full bg-gray-800 p-8 rounded-lg shadow-lg mt-10">
        <h2 class="text-3xl font-extrabold text-center mb-8">Your BMI History</h2>
        <?php if ($records): ?>
        <table class="min-w-full bg-gray-700 text-left rounded-lg overflow-hidden shadow-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b-2 border-gray-800">Date</th>
                    <th class="px-4 py-2 border-b-2 border-gray-800">Height (cm)</th>
                    <th class="px-4 py-2 border-b-2 border-gray-800">Weight (kg)</th>
                    <th class="px-4 py-2 border-b-2 border-gray-800">BMI</th>
                    <th class="px-4 py-2 border-b-2 border-gray-800">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                <tr>
                    <td class="px-4 py-2 border-b border-gray-600"><?php echo date('Y-m-d H:i:s', strtotime($record['RecordedAt'])); ?></td>
                    <td class="px-4 py-2 border-b border-gray-600"><?php echo htmlspecialchars($record['Height']); ?></td>
                    <td class="px-4 py-2 border-b border-gray-600"><?php echo htmlspecialchars($record['Weight']); ?></td>
                    <td class="px-4 py-2 border-b border-gray-600"><?php echo htmlspecialchars($record['BMI']); ?></td>
                    <td class="px-4 py-2 border-b border-gray-600 flex space-x-2">
                        <a href="history.php?action=edit&id=<?php echo $record['RecordID']; ?>"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                            Edit
                        </a>
                        <a href="history.php?action=delete&id=<?php echo $record['RecordID']; ?>"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded"
                            onclick="return confirm('Are you sure you want to delete this record?');">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center text-gray-400">No records found.</p>
        <?php endif; ?>
    </div>

    <!-- Back Button -->
    <div class="mt-8">
        <a href="../index.php" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
            Back | Make another calculation
        </a>
    </div>
</div>

<?php require '../includes/footer.php'; ?>
