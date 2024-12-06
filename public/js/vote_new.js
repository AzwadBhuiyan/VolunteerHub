document.addEventListener('DOMContentLoaded', function() {
    // Use event delegation for better performance
    document.addEventListener('click', function(event) {
        const voteButton = event.target.closest('.new-vote-btn');
        if (!voteButton) return;

        const votableType = voteButton.dataset.newVotableType;
        const votableId = voteButton.dataset.newVotableId;
        const voteCount = voteButton.nextElementSibling;
        const thumbsUp = voteButton.querySelector('.new-vote-icon');
        const currentVoteStatus = voteButton.dataset.newVoteStatus === 'true';

        // Optimistic UI update
        updateVoteUI(!currentVoteStatus, voteButton, thumbsUp);
        const previousCount = parseInt(voteCount.textContent);
        voteCount.textContent = previousCount + (!currentVoteStatus ? 1 : -1);

        fetch('/idea-board/vote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                votable_type: votableType,
                votable_id: votableId,
                vote: 1
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update vote count with actual server value
                voteCount.textContent = data.newVoteCount;
                updateVoteUI(data.voted, voteButton, thumbsUp);
                voteButton.dataset.newVoteStatus = data.voted;
            }
        })
        .catch(error => {
            // Revert optimistic updates on error
            updateVoteUI(currentVoteStatus, voteButton, thumbsUp);
            voteCount.textContent = previousCount;
            console.error('Error:', error);
        });
    });
});

function updateVoteUI(voted, button, icon) {
    if (voted) {
        button.classList.add('text-blue-500');
        icon?.classList.add('text-blue-500');
    } else {
        button.classList.remove('text-blue-500');
        icon?.classList.remove('text-blue-500');
    }
}