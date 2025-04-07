<style>
    /* Auth buttons container */
    .auth-buttons {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    /* Play Button (No border) */
    .play-button {
        background: black;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    /* Sign In Button (White - No border) */
    .sign-in-button {
        background: white;
        color:  #ff2a2a;
        padding: 10px 22px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    /* Sign Out Button (Black - No border) */
    .sign-out-button {
        background:  #ff2a2a;
        color: white;
        padding: 10px 22px;
        border-radius: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    /* Hover effects */
    .play-button:hover {
        background: #333;
        transform: scale(1.05);
    }

    .sign-in-button:hover {
        background: #f5f5f5;
        transform: translateY(-2px);
    }

    .sign-out-button:hover {
        background: #333;
        transform: translateY(-2px);
    }

</style>
<header>
    <img src="/assets/image/logo/logo.png" alt="XING FU CHA Logo">
    <nav>
        <ul>
            <li><a href="/gift-card">Gift Card</a></li>
            <li><a href="/locations">Locations</a></li>
            <li><a href="/join-the-team">Join The Team</a></li>
        </ul>
    </nav>


    <div class="auth-buttons">
    <button class="sign-in-button" onclick="window.location.href='/login'">Sign In</button>
    <button class="sign-out-button" onclick="window.location.href='/register'">Sign Out</button>
  </div>
</header>

