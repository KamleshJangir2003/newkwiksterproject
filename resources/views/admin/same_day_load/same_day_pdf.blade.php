<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Same Day Load Carrier Agreement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            margin: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
        }

        p {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .signature-section {
            margin-top: 30px;
        }

        .signature-section p {
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            .signature-section p {
                margin-bottom: 20px;
            }
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 200px;
            height: auto;
        }

        .content {
            line-height: 1.6;
        }

        .content input {
            border: none;
            border-bottom: 1px solid black;
            width: 300px;
        }

        .content .date {
            width: 100px;
        }
    </style>
</head>

<body>
    <form id="myForm">
    <div class="container">
        <div class="header">
            <img src="{{ asset('same_day_load/logo.png') }}" alt="Company Logo">
        </div>
        <h3>Dispatch to Carrier Agreement</h3>
        <p>Prepared for <input type="text" class="input-field" name="name1" value="{{$data->name1}}" id="name1" style="border:none;border-bottom: #000 solid 1px" readonly></p>
        <p>Created by Same Day Loads Dispatch Agency, LLC</p>

        <p>This agreement made as of this <input type="text" class="input-field" name="name2"  value="{{$data->name2}}" id="name2"
                style="border:none;border-bottom: #000 solid 1px;width:50px">day of <input type="text"
                class="input-field" name="name3"  id="name3"  value="{{$data->name3}}" style="border:none;border-bottom: #000 solid 1px;width:50px"> , 2024 , by and
            between Same Day Loads Dispatch Agency, LLC hereinafter referred to as Dispatch and <input type="text"
                class="input-field" name="name4"  id="name4"  value="{{$data->name4}}" style="border:none;border-bottom: #000 solid 1px">(Contact Name) of <input
                type="text" class="input-field" name="name5"  id="name5"  value="{{$data->name5}}" style="border:none;border-bottom: #000 solid 1px">(Company Name),
            hereinafter referred to as Carrier. Whereas, Carrier is a MOTOR CONTRACT CARRIER,
            desiring to retain Dispatch by executing a Limited Power of Attorney form to secure freight and
            dispatch Carrier's equipment. Whereas, Dispatch is a transportation dispatcher handling the
            necessary paperwork between brokers, shippers and the Carrier. The Carrier must prior to the
            implementation of this agreement furnish to Dispatch the following:</p>

        <ul>
            <li>A signed Limited Power of Attorney form.</li>
            <li>Copy of Carrier's Authority.</li>
            <li>Proof of Insurance Certificates</li>
            <li>We require at least $1,000,000 in Liability and at least $100,000 in Cargo coverage.</li>
            <li>A signed W-9.</li>
            <li>This Agreement form completed, dated, and signed.</li>
            <li>Statement of Work</li>
            <li>Find freight that best matches the profile for the Carrier.</li>
            <li>Upon the Carrier agreeing to the load, Dispatch will fax or email to shipper / broker
                the Carriers, Authority, W-9, proof of insurance, and order insurance certificate
                required, along with any other required supporting documentation.
            </li>
        </ul>
        <p>Handle the setting of appointments if necessary. (depending on agreement) 4. Prepare
            directions to shipper/consignee, if necessary (depending on agreement) 5. Assist with any
            problems that arise in the transit of the load when necessary, within our capabilities.
            (depending on agreement) Carrier is responsible for its own equipment, we can direct you
            to a service that may be helpful.</p>
        <p>All load information is available to the Carrier at all times, Dispatch will hold on to the
            dispatch, accessorial information, etc. until the load is completed.
            Upon forwarding the final load confirmation, and mailing all documentation to the Carrier, the
            services of Dispatch have been fully performed.
        </p>
        <ul>
            <li>Obligation of Dispatch.</li>
            <li>Dispatcher agrees to handle paperwork, phone, and fax or mail to and from the Broker
                or Shipper to tender commodities or shipments to Carrier for transportation in interstate
                commerce by Carrier between points and places within the scope of Carrier’s operating
                authority. 2. Dispatcher bears no financial or legal responsibility in the transaction
                between the Shipper, Carrier agreement.</li>
            <li>Dispatcher will:</li>
            <li>Make a 100% effort to keep Carriers truck(s) loaded.</li>
            <li> Carrier will be contacted about every load we find or offer, and the driver will Accept or
                Reject the load.</li>
            <li>Invoice the Carrier at time of service, also provide a copy of each load Confirmation
                Sheet, Carrier is being billed for</li>
        </ul>
        <p>1. Carrier gives Dispatch authority to provide his/her signature for rate confirmation sheets,
            invoices and associated paperwork necessary for securing cargo and billing purposes.
        </p>
        <p>2. Carrier agrees to collect payment from the Shipper promptly, following receipt of a freight
            bill and proof of delivery of each shipment to its assigned destination, free of damage or
            shortage. The amount to be paid by Shipper to Carrier shall be established between the
            parties on a per shipment basis prior to commencement of each individual shipment.
        </p>
        <p>A load confirmation including details of shipment and revenue to be paid will be supplied via
            FAX or EMAIL by Shipper to Carrier. Confirmation will be signed by Dispatch and returned via
            FAX or EMAIL to Shipper.
        </p>
        <p>3. Obligations of Carrier
            The Carrier agrees to pay Dispatch:
            After the load has been booked and the dispatcher tells the carrier the rate confirmation has
            been sent through email to the carrier, Our Lead Dispatcher will send payment invoice links
            to the carrier via text or email.
        </p>
        <p>Same Day Loads Dispatch Agency, LLC will charge carriers to as low as <input type="text" class="input-field" name="name6"  id="name6"  value="{{$data->name6}}"
            style="border:none;border-bottom: #000 solid 1px;width:100px">per
            completed load.
        </p>
        <p>These agreed term rates will be required to be paid to Dispatch as per the conditions of the
            agreement. All payments must be paid once rate confirmation is sent to carriers email After no
            payment or response from the carrier within rate confirmation is sent, if payment is overdue, the
            account may be placed for collection and penalty to carriers DOT/MC, such as a freight guard,
            unpaid service fees, etc.
        </p>
        <p>Same Day Loads Dispatch Agency, LLC will invoice the Carrier as per the terms of the
            agreement via email or text. Payment can be made to Dispatch by payment invoice link sent by
            Same Day Loads Dispatch Agency. Once the payment is processed the Carrier will be sent a
            confirmation receipt via email, text, or fax.
        </p>
        <p>4. Confidentiality
            Same Day Loads Dispatch Agency shall not disclose to any third party any details regarding the
            Client’s business, including, without limitation any information regarding any of the Client’s
            customer information, business plans, or price points (the Confidential Information), (ii) make
            copies of any Confidential Information or any content based on the concepts contained within
            the Confidential Information for personal use or for distribution unless requested to do so by the
            Client, or (iii) use Confidential Information other than solely for the benefit of the Client. 6.
            Disclaimer
        </p>
        <p>Dispatch is NOT responsible for: </p>
        <ul>
            <li>Billing Issues</li>
            <li>Load problems</li>
            <li>Advances: All advances will have to be handled directly between Carrier and Shipper/Broker.</li>
            <li>Handling and storage of paperwork: All documents will be sent to Carrier unless other arrangements are
                made.</li>
            <li>DOT compliance issues</li>
            <li>SPIKE INSURANCE</li>
            <li>Non-Solicitation of Customers: During the term of this Agreement and for 12 months thereafter, the
                Consultant will not, directly or indirectly, solicit or attempt to solicit any business from any of the
                Company’s clients, prospects, employees, or contractors.</li>
            <li>Non-Solicitation of Employees: During the term of this Agreement and for 12 months thereafter, the
                Consultant will not, directly or indirectly, recruit, solicit, or induce, or attempt to recruit,
                solicit, or induce, any of the Company’s employees or contractors for work at another company.</li>
            <li>Governing Law: This agreement shall be governed by and construed in accordance with the laws of the
                State of Virginia without giving effect to any choice of law or conflict of laws provision or rule
                (whether of the State of Virginia or any other jurisdiction) that would cause the application of the
                laws of any jurisdiction other than those of the State of Virginia.</li>
        </ul>
        <p>5. Jurisdictions and Venue
            Same Day Loads Dispatch Agency and the Carrier hereby consent to and agree to submit to
            the jurisdiction of the Federal and state courts located in Virginia in connection with any claims
            or controversies arising out of the Agreement. IN WITNESS WHEREOF, the parties hereto have
            executed this Agreement as the date written.
        </p>
        <p>6. Applicable Law
            This Consulting Agreement and the interpretation of its terms shall be governed by and
            construed in accordance with the laws of the State of Virginia and subject to the exclusive
            jurisdiction of the federal and state courts located in Virginia, USA.</p>
        <p>7.By signing this carrier packet you have agreed to have consent in the Opt-In and Opt-Out
            options for SMS messages. These options will be sent to you via text with directions on how to
            reply, for example, reply START or reply STOP.</p>
        <p>IN WITNESS WHEREOF, each of the Parties has executed this Consulting Agreement,
            both Parties by its duty authorized officer, as of the day and year set forth below. Dispatch:
            Same Day Loads Dispatch Agency.
        </p>
        <p>I,<input type="text" class="input-field" name="name7"  id="name7"  value="{{$data->name7}}"
            style="border:none;border-bottom: #000 solid 1px;width:150px">hereby appoint "Same Day Loads Dispatch
            Agency, LLC</p>
        <p>
            " of "Law Office of Seaton & Husk, LP 2240 Gallows Road Vienna, VA 22182", as my
            Attorney-in-Fact ("Agent")."Same Day Loads Dispatch Agency, agents shall have full power and
            authority to act on my behalf. This power and authority shall authorize "Same Day Loads
            Dispatch Agency, LLC

        </p>
        <p>manage and conduct affairs and to exercise all of my legal rights and powers, including all
            rights and powers that I may acquire in the future. Same Day Loads Dispatch Agency powers
            shall include, but not be limited to, the power to:</p>
            <p>1. Contact shippers and brokers on my behalf for cargo</p>
            <p>2. Transfer of Paperwork (Carrier Packet, Rate Confirmations, Insurance Certificates, Invoices
                and all necessary Paperwork) to shippers.</p>
                <p>3. Sign and Execute Rate Confirmations for freight on my behalf.</p>
                <p>This Power of Attorney shall be construed broadly as a General Power of Attorney. The listing
                    of Specific powers is not intended to limit or restrict the general powers granted in this Power of
                    Attorney in any manner. "Same Day Loads Dispatch Agency, LLC shall not be liable for any loss
                    that results from a judgment error that was made in good faith. However, “Same Day Loads
                    Dispatch Agency, LLC" shall be liable for willful misconduct or the failure to act in good faith
                    while acting under the authority of this Power of Attorney.
                    </p>
                    <p>I authorize my Agent to indemnify and hold harmless any third party who accepts and acts
                        under this document. “Same Day Loads Dispatch Agency, LLC " shall be entitled to reasonable
                        compensation for any services provided as my Agent. "Same Day Loads Dispatch Agency, LLC"
                        shall be entitled to reimbursement of all reasonable expenses incurred in connection with this
                        Power of Attorney. "Same Day Loads Dispatch Agency, LLC" shall provide an accounting for all
                        acts performed as my Agent, if I so request or if such a request is made by any authorized
                        personal representative or fiduciary acting on my behalf. This Power of Attorney shall become
                        effective immediately and shall not be affected by my disability or lack of mental competence,except as may be provided otherwise by an applicable state statute. This is a Durable Power of
                        Attorney. This Power of Attorney shall continue effective for (12 Months). This Power of Attorney
                        may be revoked by me at any time by providing (15 Days) written notice to my Agent. Dated                        
                        </p>
                        <div class="signature-section">
                            <p>Date <input type="text" class="input-field" name="name8"  id="name8"  value="{{$data->name8}}"
                                style="border:none;border-bottom: #000 solid 1px;width:150px"></p>
                                 <img src="{{ 'https://samedayloads.com/' . $data->signature }}" height="100px">
                        <br>
                            <p>________________________________Signature</p>
                            <p><input type="text" class="input-field" name="name9"  id="name9"  value="{{$data->name9}}"
                                style="border:none;border-bottom: #000 solid 1px;width:250px">Printed Name</p>
                        </div>
                    </form>
    </div>
     <script>
            window.onload = function() {
  window.print();
};
        </script>
</body>

</html>
