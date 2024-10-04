document.addEventListener('DOMContentLoaded', function() {
    const voteButtons = document.querySelectorAll('.vote-button');

    voteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const votableType = this.dataset.votableType;
            const votableId = this.dataset.votableId;
            const voteIcon = this.querySelector('.vote-icon');
            const voteCount = this.nextElementSibling;

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
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    voteCount.textContent = data.newVoteCount;
                    if (data.voted) {
                        voteIcon.setAttribute('fill', 'currentColor');
                    } else {
                        voteIcon.setAttribute('fill', 'none');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});