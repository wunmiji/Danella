import { CountUp } from '/assets/js/library/countUp.min.js';

const countUpYearsText = document.getElementById("countUpYears");
const countUpProjectsText = document.getElementById("countUpProjects");
const countUpClientsText = document.getElementById("countUpClients");

var countUpYears = new CountUp('countUpYears',
  countUpYearsText.dataset.count,
  { duration: 3, enableScrollSpy: true });
countUpYears.start();

var countUpProjects = new CountUp('countUpProjects',
  countUpProjectsText.dataset.count,
  { duration: 3, enableScrollSpy: true });
countUpProjects.start();

var countUpClients = new CountUp('countUpClients',
  countUpClientsText.dataset.count,
  { duration: 3, enableScrollSpy: true });
countUpClients.start();