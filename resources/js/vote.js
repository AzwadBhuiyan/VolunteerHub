document.addEventListener('DOMContentLoaded', function() {
    const voteButtons = document.querySelectorAll('.vote-button');

    voteButtons.forEach(button => {
        // Set initial state
        const isVoted = button.dataset.voted === 'true';
        const voteIcon = button.querySelector('.vote-icon');
        
        if (isVoted) {
            button.classList.add('text-blue-500');
            voteIcon.classList.add('fill-current');
        }

        button.addEventListener('click', function() {
            const votableType = this.dataset.votableType;
            const votableId = this.dataset.votableId;
            const voteCount = this.nextElementSibling;
            const voteIcon = this.querySelector('.vote-icon');

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
                    
                    // Toggle vote state for both icon and button
                    if (data.voted) {
                        this.classList.add('text-blue-500');
                        voteIcon.classList.add('fill-current');
                        this.dataset.voted = 'true';
                    } else {
                        this.classList.remove('text-blue-500');
                        voteIcon.classList.remove('fill-current');
                        this.dataset.voted = 'false';
                    }

                    // Handle like text if it exists (for comments)
                    const likeText = this.querySelector('span');
                    if (likeText) {
                        likeText.classList.toggle('text-blue-600', data.voted);
                    }

                    // Handle count container if it exists (for comments)
                    const countContainer = this.closest('.text-xs')?.querySelector('.flex.items-center');
                    if (countContainer) {
                        if (data.newVoteCount > 0) {
                            countContainer.querySelector('span:last-child').textContent = data.newVoteCount;
                        } else {
                            countContainer.remove();
                        }
                    }
                }
            });
        });
    });
});