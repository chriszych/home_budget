        function toggleButtons(activeButtonId, inactiveButtonId) {
            const activeButton = document.getElementById(activeButtonId);
            const inactiveButton = document.getElementById(inactiveButtonId);

            activeButton.classList.remove('btn-outline-primary');
            activeButton.classList.add('btn-primary');

            inactiveButton.classList.remove('btn-primary');
            inactiveButton.classList.add('btn-outline-primary');
        }