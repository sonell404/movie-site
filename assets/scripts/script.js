document.addEventListener('DOMContentLoaded', () => {
	const toggleButton = document.getElementsByClassName('toggle-button')[0];
	const navbarLinks = document.getElementsByClassName('navbar-links')[0];

	if (toggleButton)
	{
		toggleButton.addEventListener('click', () => {
			navbarLinks.classList.toggle('active');
		});
	}
	else
	{
		alert('ERROR');
	}
});