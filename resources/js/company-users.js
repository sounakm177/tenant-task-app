document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.toggle-user-status').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();

            const userId = button.dataset.userId;
            const companyId = button.dataset.companyId;
            const action = button.dataset.action; // 'activate' or 'deactivate'
            const url = `/companies/${companyId}/users/${userId}/${action}`;

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (data.success) {
                    // Update button text and color
                    if (action === 'activate') {
                        button.dataset.action = 'deactivate';
                        button.textContent = 'Deactivate';
                        button.classList.remove('text-green-700');
                        button.classList.add('text-yellow-700');
                    } else {
                        button.dataset.action = 'activate';
                        button.textContent = 'Activate';
                        button.classList.remove('text-yellow-700');
                        button.classList.add('text-green-700');
                    }
                }
            } catch (err) {
                console.error(err);
                alert('Something went wrong!');
            }
        });
    });

});
