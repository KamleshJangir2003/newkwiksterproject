@extends('front.app')
@section('main')
<style>
  .banner {
    background-image: url('{{asset('wp-content/uploads/truck_load.webp')}}');
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 400px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.banner-content {
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.banner-content h1 {
    margin-bottom: 10px;
    font-size: 3em;
}

.banner-content p {
    margin-bottom: 0;
    font-size: 1.2em;
}

@media (max-width: 768px) {
    .banner-content h1 {
        font-size: 2em;
    }

    .banner-content p {
        font-size: 1em;
    }
}

.inquiry-banner {
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    height: 100vh;
    margin-top: 50px;
}

.inquiry-banner-image {
    background-image:  url('{{asset('wp-content/uploads/truck_load02.jpeg')}}');
    background-size: cover;
    background-position: center;
    flex: 1;
    min-height: 300px;
}

.inquiry-banner-form {
    background: rgb(231, 231, 231);
    padding: 40px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center; /* Center align form contents */
    min-height: 300px;
}

.inquiry-banner-form h1 {
    margin-bottom: 20px;
    font-size: 2em;
    color: #333;
    text-align: center; /* Center the heading */
}

.form-group {
    width: 100%;
    max-width: 700px; /* Adjust max-width as needed */
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.form-group input, .form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
    box-sizing: border-box; /* Ensure padding is included in width */
}

button {
    background-color: #28a745;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

@media (max-width: 768px) {
    .inquiry-banner {
        flex-direction: column;
    }
    
    .inquiry-banner-image {
        display: none; /* Hide the image on small screens */
    }
    
    .inquiry-banner-form {
        flex: none; /* Remove flex grow to fit content */
        width: 100%;
        padding: 20px; /* Reduce padding for smaller screens */
    }
}
#popupForm, #successPopup {
    position: relative;
    display: none;
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: white;
    background-image: url('{{asset('wp-content/uploads/truck06.jpeg')}}');
    border: 1px solid #ccc;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    width: 80%;
    max-width: 600px;
    box-sizing: border-box;
}

#popupOverlay {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

#successPopup {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}



form button {
    padding: 10px;
    font-size: 1em;
    cursor: pointer;
    margin-top: 10px;
}

#closeButtonTop {
    background-color: #ff4c4c;
    color: white;
    border: none;
}

.bottom-close-button {
    background-color: #ff4c4c;
    color: white;
    border: none;
    margin-top: 20px;
}


@media (max-width: 600px) {
    .col-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
    </style>
    <div id="popupOverlay"></div>
     @if(session('success'))
     <div id="successPopup" >
         <p >{{ session('success') }}</p>
         <button type="button" id="successCloseButton" style="display: inline-block;">Close</button>
     </div>
     @endif
<div class="banner">
    <div class="banner-content">
        <h1>Loads</h1>
        <p>
            We provide efficient and reliable trucking load services, offering both Full Truckload (FTL) and Less Than Truckload (LTL) options to meet your transportation needs. Trust us to manage your cargo with precision and safety, ensuring timely deliveries.</p>
    </div>
</div>
<div class="inquiry-banner">
    <div class="inquiry-banner-image"></div>
    <div class="inquiry-banner-form">
        <h2>Indeed, I'm prepared to go!</h2>
        <form action="{{route('popup_store')}}" method="post" style="max-width: 500px;width:100%">
            @csrf
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="email">Phone:</label>
                <input type="phone" id="email" name="phone" required>
            </div>
            <div class="form-group">
                <label for="phone">Age:</label>
                <select id="phone" name="age" required>
                    <option value="">Are You Over 21?(Y/N)</option>
                    <option value="yes">Yes</option>
                    <option value="No">No</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
        document.getElementById('popupOverlay').style.display = 'block';
var successPopup = document.getElementById('successPopup');
successPopup.style.display = 'block';
successPopup.style.textAlign = 'center'; // Add this line to center the text
document.getElementById('successCloseButton').addEventListener('click', function() {
    document.getElementById('popupOverlay').style.display = 'none';
    successPopup.style.display = 'none';
});
setTimeout(function() {
    document.getElementById('popupOverlay').style.display = 'none';
    successPopup.style.display = 'none';
}, 5000);
        @endif
    });
</script>
@endsection