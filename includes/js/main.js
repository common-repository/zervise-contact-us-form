console.log(
  '%c👋 Hello from Zervise!',
  'color:#54c9ff;font-family:system-ui;font-size:1.6rem;-webkit-text-stroke: 1px black;font-weight:bold;'
);

// Global app state
let state = {
  errors: [],
};

const zerviseBtn = document.querySelector('.cu-zervise-btn');
let zerviseContainerClass = 'cu-zervise-container-3';
if (zerviseBtn.classList.contains('cu-zervise-btn-1'))
  zerviseContainerClass = 'cu-zervise-container-1';
else if (zerviseBtn.classList.contains('cu-zervise-btn-2'))
  zerviseContainerClass = 'cu-zervise-container-2';
else zerviseContainerClass = 'cu-zervise-container-3';

const subdomainURL = zerviseBtn.getAttribute('data-subdomain');
const subdomain = subdomainURL
  .split('zervise.com/')[0]
  .split('https://')[1]
  .split('.')[0];

// shows error as a div
const showError = (msg, removalTime = 10000) => {
  const errorcontainer = document.createElement('div');
  errorcontainer.classList.add('error-container');
  errorcontainer.innerText = msg;

  document.body.appendChild(errorcontainer);

  setTimeout(() => {
    errorcontainer.remove();
  }, +removalTime);
};

// shows success message as a div
const showSuccess = (msg, removalTime = 5000) => {
  const successContainer = document.createElement('div');
  successContainer.classList.add('success-container');
  successContainer.innerText = msg;

  document.body.appendChild(successContainer);

  setTimeout(() => {
    successContainer.remove();
  }, +removalTime);
};

// starts loading state
const startLoading = () => {
  document.querySelector('.submit-btn').innerHTML =
    '<i class="fas fa-circle-notch"></i> &nbsp;Submitting Ticket...';
  document.querySelector('.submit-btn').classList.add('loading');
  document.querySelector('#ticket-name').value = '';
  document.querySelector('#ticket-email').value = '';
  document.querySelector('#ticket-mobile').value = '';
  document.querySelector('#ticket-desc').value = '';
};

// ends loading state
const finishLoading = () => {
  document.querySelector('.submit-btn').innerHTML =
    '<i class="far fa-check-circle"></i> &nbsp;Submit Ticket Now';
  document.querySelector('.submit-btn').classList.remove('loading');
};

// makes a request to the zervise api
const makeRequest = async (
  url = '',
  method = 'GET',
  headers = {},
  data = {},
  successMsg = 'Success',
  isFormData = false
) => {
  startLoading();

  fetch(url, {
    method,
    headers,
    body: isFormData ? data : JSON.stringify(data),
  })
    .then((result) => {
      if (!result.ok) throw result;
      return result.json();
    })
    .then((result) => {
      finishLoading();
      showSuccess(successMsg);
      console.log(state);
    })
    .catch((error) => {
      console.log(error.status);
      if (error.status == 401) {
        showError('Session expired! Refresh the page to login again.');
      } else {
        error.json().then((body) => {
          state.errors = body.errors;

          document.querySelector('.submit-btn').innerHTML =
            '<i class="far fa-check-circle"></i> &nbsp;Submit Ticket Now';
          document.querySelector('.submit-btn').classList.remove('loading');
          state.errors.forEach((err) => {
            showError(err.msg);
          });

          console.log(state);
        });
      }
    });
};

// adds the form in a div
const addZerviseDiv = () => {
  const hideZerviseDiv = () => {
    document.querySelector('.cu-zervise-container').remove();
  };

  const container = document.createElement('div');
  container.classList.add('cu-zervise-container', zerviseContainerClass);

  container.innerHTML = `<div class="close-btn"><i class='fas fa-times close-btn-icon'></i></div><p class="cu-zervise-head"><i class="fas fa-envelope"></i> &nbsp;Contact Us</p><form class="cu-zervise-form"><input id="ticket-name" type="text" placeholder="Enter your name" required></input><input id="ticket-email" type="email" placeholder="Enter your email" required></input><input id="ticket-mobile" type="number" placeholder="Enter mobile number (Optional)"></input></input> <textarea id="ticket-desc" type="text" rows="8" placeholder="Describe your issue..." required></textarea> <button type="submit" value="Create Ticket" class="submit-btn"><i class="far fa-check-circle"></i> &nbsp;Submit Ticket Now</button></form> <p class="footer-txt">⚡ Powered by <a href="https://zervise.com/" target="_blank">Zervise</a></p>`;

  document.body.appendChild(container);

  // button for closing the form
  document
    .querySelector('.close-btn')
    .addEventListener('click', hideZerviseDiv);

  const zerviseForm = document.querySelector('.cu-zervise-form');

  // submitting the form
  zerviseForm.addEventListener('submit', (e) => {
    e.preventDefault();

    let name = e.target[0].value;
    let email = e.target[1].value;
    let mobile = e.target[2].value;
    let description = e.target[3].value;

    const url = `https://api.zervise.com/auth/user/external-app/${subdomain}`;
    const headers = {
      'Content-Type': 'application/json',
    };
    const data = {
      name,
      email,
      appName: 'wordpress',
      mobile,
      description,
      source: 'Wordpress',
    };
    console.log(data);

    makeRequest(
      url,
      'POST',
      headers,
      data,
      'Ticket created successfully',
      false
    );
  });
};

zerviseBtn.addEventListener('click', () => {
  console.log('hello');
  addZerviseDiv();
});
