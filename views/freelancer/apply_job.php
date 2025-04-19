<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply to Job</title>
    <link rel="stylesheet" href="/public/css/style.css"> <!-- Optional -->
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 700px;
            margin: auto;
            background-color: #f7f7f7;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Apply to Job: <?= isset($job['job_title']) ? htmlspecialchars($job['job_title']) : 'Unknown Job' ?></h2>


<form action="index.php?controller=freelancerApplication&action=submitApplication" method="post" enctype="multipart/form-data">

    <input type="hidden" name="job_id" value="<?= htmlspecialchars($_POST['job_id'] ?? '') ?>">

    
    <label>Cover Letter:</label>
    <textarea name="cover_letter" required></textarea><br>

    <label>Expected Duration:</label>
    <input type="text" name="expected_duration" required><br>

    <label>Proposed Budget:</label>
    <input type="number" name="proposed_budget" required><br>

    <label>Experience Summary:</label>
    <textarea name="experience_summary" required></textarea><br>

    <label>Skills Used:</label>
    <textarea name="skills_used" required></textarea><br>

    <label>Available Start Date:</label>
    <input type="date" name="available_start_date" required><br>

    <label>Expected End Date:</label>
    <input type="date" name="expected_end_date" required><br>

    <label>Attachment (Optional):</label>
    <input type="file" name="attachment"><br><br>

    <button type="submit">Apply</button>
</form>




</body>
</html>
