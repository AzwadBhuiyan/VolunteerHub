document.addEventListener('DOMContentLoaded', function() {
    const voteButtons = document.querySelectorAll('.vote-button');
    
    voteButtons.forEach(button => {
        // Set initial state
        const isVoted = button.dataset.voted === 'true';
        
        if (isVoted) {
            button.classList.add('text-blue-500');
            if (button.querySelector('i')) {
                button.querySelector('i').classList.add('text-blue-500');
            }
        }

        button.addEventListener('click', function() {
            const votableType = this.dataset.votableType;
            const votableId = this.dataset.votableId;
            const voteCount = this.nextElementSibling;
            const thumbsUp = this.querySelector('i');

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
                    // Update vote count
                    voteCount.textContent = data.newVoteCount;
                    
                    // Toggle vote state
                    if (data.voted) {
                        this.classList.add('text-blue-500');
                        if (thumbsUp) {
                            thumbsUp.classList.add('text-blue-500');
                        }
                        this.dataset.voted = 'true';
                    } else {
                        this.classList.remove('text-blue-500');
                        if (thumbsUp) {
                            thumbsUp.classList.remove('text-blue-500');
                        }
                        this.dataset.voted = 'false';
                    }
                }
            });
        });
    });
});