<div class="freelancer-profile">
<?php if (!empty($profile['profile_picture'])): ?>
        <div class="profile-picture">
            <img src="public/uploads/<?= htmlspecialchars($profile['profile_picture']) ?>" width="120" alt="Profile Picture">
        </div>
    <?php endif; ?>
    <h2 class="profile-name"><?= htmlspecialchars($basicInfo['first_name'] . ' ' . $basicInfo['last_name']) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($basicInfo['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($profile['phone']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($profile['address']) ?></p>

   

    <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($profile['bio'])) ?></p>
    <p><strong>Experience:</strong> <?= nl2br(htmlspecialchars($profile['experience'])) ?></p>
    <p><strong>Skills:</strong> <?= nl2br(htmlspecialchars($profile['skills'])) ?></p>
</div>

<!-- Internal CSS -->
<style>
/* Profile Popup Styles */
.freelancer-profile {
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 600px;
    margin: 0 auto;
    font-family: 'Arial', sans-serif;
    color: #333;
    line-height: 1.6;
    overflow: hidden;
    text-align: left;
}

.freelancer-profile h2.profile-name {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
    border-bottom: 2px solid #ff9800;
    padding-bottom: 10px;
}

.freelancer-profile p {
    margin-bottom: 15px;
    font-size: 1rem;
}

.freelancer-profile p strong {
    font-weight: bold;
    color: #555;
}

.profile-picture {
    text-align: center;
    margin-bottom: 20px;
}

.profile-picture img {
    border-radius: 50%;
    border: 4px solid #ff9800;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.freelancer-profile p.bio,
.freelancer-profile p.experience,
.freelancer-profile p.skills {
    font-size: 1rem;
    color: #555;
    word-wrap: break-word;
}

.freelancer-profile p.bio,
.freelancer-profile p.experience {
    line-height: 1.8;
}

.freelancer-profile p.skills {
    font-style: italic;
    color: #00796b;
}

.freelancer-profile p:last-child {
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .freelancer-profile {
        padding: 20px;
    }

    .freelancer-profile h2.profile-name {
        font-size: 1.6rem;
        text-align: center;
    }
}
</style>
