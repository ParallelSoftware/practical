##Task 1:
Directory: /task1
CSV File: /task1/csv/Candidates_Excel.csv
You are required to bubble sort an array of Candidates based on their age. You will be given a CSV file containing a list of Candidates and their respective ages. You will need to do the following:
- Create a simplistic file upload page in PHP where the user can upload the csv file.
- You then need to extract the candidates and their ages from the CSV file into a non-associative array, do a Bubble-Sort based on their Age(ascending) and do the following:
 - Display the sorted candidates in an html table.
 - Using JQuery, ASYNCHRONOUSLY POST the sorted candidate array to a handler file that will:
  1. Insert the sorted candidates into a Mysql table called candidates within a mysql database called task1
  2. Apply the Fibbonacci sequence to the indices of the sorted character array and append each candidates name and age, comma-separated, to a new line in a flatfile called task1.csv within /task1/csv/
 - COMMIT

##Task 2:
Directory: /task2
Within the directory is another directory called 'crud'.
- Get the crud application up and running on Apache / NGnx
- Add the provided banner as a header to the app
- Fix any bugs you find along the way
