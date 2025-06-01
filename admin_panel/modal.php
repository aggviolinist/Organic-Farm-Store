
    <style>
       
    </style>

    <!-- Button to open the modal -->
    <button class="open-modal-button" onclick="openModal()">Open Modal</button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <span class="close-modal-button" onclick="closeModal()">&times;</span>
        <p>Do you want to proceed?</p>
        <div class="modal-buttons">
            <button class="yes" onclick="handleYes()">Yes</button>
            <button class="no" onclick="handleNo()">No</button>
        </div>
    </div>

    <!-- The Overlay -->
    <div class="overlay" id="overlay" onclick="closeModal()"></div>


