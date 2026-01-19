<!DOCTYPE html>
<html>
<head>
    <title>Form Submission</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <h4 style="margin: 10px">Form submit detail</h4>
  <table class="table table-bordered border-Dark" style="width: 300px;">
    <thead>
      <tr>
        <th scope="col">Form ID</th>
        <th scope="col">{{ $data['id'] ?? 'N/A' }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Company Name</th>
         <th scope="row">{{ $data['company_name'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Owner</th>
         <th scope="row">{{ $data['owner'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">DOT</th>
         <th scope="row">{{ $data['DOT'] ?? 'N/A' }}</th>
      </tr><tr>
        <th scope="row">Phone</th>
         <th scope="row">{{ $data['phone'] ?? 'N/A' }}</th>
      </tr><tr>
        <th scope="row">Email</th>
         <th scope="row">{{ $data['email'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Hauls</th>
         <th scope="row">{{ $data['Hauls'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Truck VIN</th>
         <th scope="row">{{ $data['Truck_VIN'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Trailer VIN</th>
         <th scope="row">{{ $data['Trailer_VIN'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center; ">Driver Details</td>
      </tr>
      <tr>
        <th scope="row">Driver Name</th>
         <th scope="row">{{ $data['Driver_Name'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">LN</th>
         <th scope="row">{{ $data['LN'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">DOB</th>
         <th scope="row">{{ $data['DOB'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Issued state</th>
         <th scope="row">{{ $data['Issued_state'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Cargo</th>
         <th scope="row">{{ $data['Cargo'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Physical damage</th>
         <th scope="row">{{ $data['Physical_damage'] ?? 'N/A' }}</th>
      </tr>
      <tr>
        <th scope="row">Agent Name</th>
         <th scope="row">{{ $data['Agent Name'] ?? 'N/A' }}</th>
      </tr>
    </tbody>
  </table>
</body>
</html>