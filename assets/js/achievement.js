document.addEventListener("DOMContentLoaded", function(){
    let user = {
        isLoggedIn: false,
        hasPosted: false,
        hasCommented: false
    };

    const achievements = {
        post: {
            condition: () => user.hasPosted,
            message: 'Achievement Unlocked: First Post!',
        }
    };

    function checkAchievements() {
        for (let achievement in achievements) {
            if (achievements.hasOwnProperty(achievement) && achievements[achievement].condition()) {
                showAchievement(achievements[achievement].message);
            }
        }
    }

    function showAchievement(message) {
        Swal.fire({
            title: "Sweet!",
            text: message,
            imageUrl: "assets/images/achievements/first_login.png",
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: "Custom image"
          });
    }

    document.getElementById('postBtn').addEventListener('click', function () {
        // Simulated post action
        user.hasPosted = true;
        checkAchievements();
    });
});