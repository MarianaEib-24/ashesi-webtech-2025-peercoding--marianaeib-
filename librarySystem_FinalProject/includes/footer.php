    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                     &copy; 2025 Online Library Management System | <a href="https://github.com/MarianaEib-24/ashesi-webtech-2025-peercoding--marianaeib-" target="_blank">Designed by : Mariana Eib</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Structure -->
    <div id="customModal" class="modal-overlay">
        <div class="modal-box">
            <div id="modalIcon" class="modal-icon">✨</div>
            <h3 id="modalTitle" class="modal-title">Title</h3>
            <p id="modalMessage" class="modal-message">Message goes here.</p>
            <button class="modal-btn" onclick="closeModal()">OK</button>
            <div id="modalActions" class="modal-actions"></div>
        </div>
    </div>

    <script>
        // Modal System
        function showModal(title, message, type = 'success', redirectUrl = null) {
            const modal = document.getElementById('customModal');
            const icon = document.getElementById('modalIcon');
            const titleEl = document.getElementById('modalTitle');
            const msgEl = document.getElementById('modalMessage');
            const btn = document.querySelector('.modal-btn');
            const box = document.querySelector('.modal-box');

            titleEl.innerText = title;
            msgEl.innerText = message;
            
            // Customize appearance based on type
            if (type === 'error') {
                icon.innerText = '⚠️';
                box.style.borderTop = '5px solid #e74c3c'; // Red border top
                icon.style.color = '#e74c3c';
            } else if (type === 'success') {
                icon.innerText = '✅';
                box.style.borderTop = '5px solid #27ae60'; // Green border top
                icon.style.color = '#27ae60';
            } else {
                icon.innerText = 'ℹ️';
                box.style.borderTop = '5px solid #3498db'; // Blue border top
                icon.style.color = '#3498db';
            }

            // Reset background to white (as defined in CSS) instead of gradient
            box.style.background = '#fff';

            // Handle redirect
            if (redirectUrl) {
                btn.onclick = function() {
                    window.location.href = redirectUrl;
                };
            } else {
                btn.onclick = closeModal;
            }

            modal.classList.add('open');
        }

        function closeModal() {
            document.getElementById('customModal').classList.remove('open');
        }

        // Close on outside click
        document.getElementById('customModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
