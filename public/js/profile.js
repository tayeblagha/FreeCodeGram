function followUser(username) {
    axios.post('/follow/' + username)
        .then(response => {
            var buttonText = document.getElementById('followButton').innerText;
            var followButton = document.getElementById('followButton');

            // Toggle button text
            followButton.innerText = (buttonText === "Follow") ? 'Unfollow' : 'Follow';

            // Toggle button color
            if (followButton.innerText === "Unfollow") {
                followButton.classList.remove('btn-primary');
                followButton.classList.add('btn-secondary');
            } else {
                followButton.classList.remove('btn-secondary');
                followButton.classList.add('btn-primary');
            }

           // console.log(response.data);
        })
        .catch(errors => {
            if (errors.response.status === 401) {
                window.location = '/login';
            }
        });
}
