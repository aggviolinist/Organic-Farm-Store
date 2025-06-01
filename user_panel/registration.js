function validateForm() { //This function is called when the user submits the registration form.
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; //Checks for a valid email format.
    var mobileRegex = /^[0-9]{10}$/; //Validates a 10-digit mobile number composed of numeric digits.
    var passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/; //Ensures the password has at least 8 characters, 1 uppercase letter, 1 numeric digit, and 1 special character.

    var emailInput = document.getElementById('user_email'); //references to the input elements in the HTML form using their respective id attributes.
    var emailInput = document.getElementById('user_email'); //
    var emailInput = document.getElementById('user_email'); //
    var mobileInput = document.getElementById('mobile_number');
    var passwordInput = document.getElementById('user_password');


    // chech to see if fields pass the respective regular expression tests. If any of these tests fail, an alert is displayed, and the function returns false, preventing the form from being submitted.
    if (!emailRegex.test(emailInput.value)) {
        alert('Please enter a valid email address.');
        return false;
    }

    if (!mobileRegex.test(mobileInput.value)) {
        alert('Please enter a valid 10-digit mobile number.');
        return false;
    }

    if (!passwordRegex.test(passwordInput.value)) {
        alert('Please enter a valid password with at least 8 characters, 1 uppercase, 1 special character, and 1 number.');
        return false;
    }

    // Additional validations can be added here

    //alert('Registration successful!');
    return true;
}
//