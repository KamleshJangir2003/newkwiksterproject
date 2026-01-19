<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatch to Carrier Agreement</title>
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
    <form action="{{route('sameday_process')}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="container">
        <div class="header">
            <img src="{{ asset('same_day_load/logo.png') }}" alt="Company Logo">
        </div>
        <h1>Dispatch to Carrier Agreement</h1>
        <p>Prepared for <input type="text" class="input-field" name="name1"  id="name1" value="{{$name1}}" style="border:none;border-bottom: #000 solid 1px" readonly></p>
        <p>Created by Same Day Loads Dispatch Agency, LLC</p>

        <p>This agreement made as of this <input type="text" class="input-field" name="name2"  id="name2" value="{{$name2}}"
                style="border:none;border-bottom: #000 solid 1px;width:50px">day of <input type="text"
                class="input-field" name="name3"  id="name3" value="{{$name3}}" style="border:none;border-bottom: #000 solid 1px;width:50px"> , 2024 , by and
            between Same Day Loads Dispatch Agency, LLC hereinafter referred to as Dispatch and <input type="text"
                class="input-field" name="name4"  id="name4" value="{{$name4}}" style="border:none;border-bottom: #000 solid 1px">(Contact Name) of <input
                type="text" class="input-field" name="name5"  id="name5" value="{{$name5}}" style="border:none;border-bottom: #000 solid 1px">(Company Name),
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
        <p>Same Day Loads Dispatch Agency, LLC will charge carriers to as low as <input type="text" class="input-field" name="name6"  id="name6" value="{{$name6}}"
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
        <p>I,<input type="text" class="input-field" name="name7"  id="name7" value="{{$name7}}"
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
                            <p>Date <input type="text" class="input-field" name="name8"  id="name8" value="{{$name8}}"
                                style="border:none;border-bottom: #000 solid 1px;width:150px"></p>
                                <section class="signature-component" >
                                    <h1>Draw Signature</h1>
                                    <h2>with mouse or touch</h2>
                
                                    <canvas id="signature-pad" width="400" height="200" style="border: #000 2px solid"></canvas>
                
                                    <div>
                                        <button type="button" id="clear">Clear</button>
                                        {{-- <button  type="button" id="save">save</button> --}}
                                    </div>
                                </section>
                                <input type="hidden" name="signature" id="signature">
                            <p><input type="text" class="input-field" name="name9"  id="name9" value="{{$name9}}"
                                style="border:none;border-bottom: #000 solid 1px;width:250px">Printed Name</p>
                        </div>
                        <button type="submit"   id="save" style="padding:20px;background-color:green;margin-left:150px;color:#fff;border:none">Submit</button>
        
                       
    </div>
</form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script>
        var SignaturePad = (function(document) {
            "use strict";

            var log = console.log.bind(console);

            var SignaturePad = function(canvas, options) {
                var self = this,
                    opts = options || {};

                this.velocityFilterWeight = opts.velocityFilterWeight || 0.7;
                this.minWidth = opts.minWidth || 0.5;
                this.maxWidth = opts.maxWidth || 2.5;
                this.dotSize = opts.dotSize || function() {
                    return (self.minWidth + self.maxWidth) / 2;
                };
                this.penColor = opts.penColor || "black";
                this.backgroundColor = opts.backgroundColor || "rgba(0,0,0,0)";
                this.throttle = opts.throttle || 0;
                this.throttleOptions = {
                    leading: true,
                    trailing: true
                };
                this.minPointDistance = opts.minPointDistance || 0;
                this.onEnd = opts.onEnd;
                this.onBegin = opts.onBegin;

                this._canvas = canvas;
                this._ctx = canvas.getContext("2d");
                this._ctx.lineCap = 'round';
                this.clear();

                // we need add these inline so they are available to unbind while still having
                //  access to 'self' we could use _.bind but it's not worth adding a dependency
                this._handleMouseDown = function(event) {
                    if (event.which === 1) {
                        self._mouseButtonDown = true;
                        self._strokeBegin(event);
                    }
                };

                var _handleMouseMove = function(event) {
                    event.preventDefault();
                    if (self._mouseButtonDown) {
                        self._strokeUpdate(event);
                        if (self.arePointsDisplayed) {
                            var point = self._createPoint(event);
                            self._drawMark(point.x, point.y, 5);
                        }
                    }
                };

                this._handleMouseMove = _.throttle(_handleMouseMove, self.throttle, self.throttleOptions);
                //this._handleMouseMove = _handleMouseMove;

                this._handleMouseUp = function(event) {
                    if (event.which === 1 && self._mouseButtonDown) {
                        self._mouseButtonDown = false;
                        self._strokeEnd(event);
                    }
                };

                this._handleTouchStart = function(event) {
                    if (event.targetTouches.length == 1) {
                        var touch = event.changedTouches[0];
                        self._strokeBegin(touch);
                    }
                };

                var _handleTouchMove = function(event) {
                    // Prevent scrolling.
                    event.preventDefault();

                    var touch = event.targetTouches[0];
                    self._strokeUpdate(touch);
                    if (self.arePointsDisplayed) {
                        var point = self._createPoint(touch);
                        self._drawMark(point.x, point.y, 5);
                    }
                };
                this._handleTouchMove = _.throttle(_handleTouchMove, self.throttle, self.throttleOptions);
                //this._handleTouchMove = _handleTouchMove;

                this._handleTouchEnd = function(event) {
                    var wasCanvasTouched = event.target === self._canvas;
                    if (wasCanvasTouched) {
                        event.preventDefault();
                        self._strokeEnd(event);
                    }
                };

                this._handleMouseEvents();
                this._handleTouchEvents();
            };

            SignaturePad.prototype.clear = function() {
                var ctx = this._ctx,
                    canvas = this._canvas;

                ctx.fillStyle = this.backgroundColor;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                this._reset();
            };

            SignaturePad.prototype.showPointsToggle = function() {
                this.arePointsDisplayed = !this.arePointsDisplayed;
            };

            SignaturePad.prototype.toDataURL = function(imageType, quality) {
                var canvas = this._canvas;
                return canvas.toDataURL.apply(canvas, arguments);
            };

            SignaturePad.prototype.fromDataURL = function(dataUrl) {
                var self = this,
                    image = new Image(),
                    ratio = window.devicePixelRatio || 1,
                    width = this._canvas.width / ratio,
                    height = this._canvas.height / ratio;

                this._reset();
                image.src = dataUrl;
                image.onload = function() {
                    self._ctx.drawImage(image, 0, 0, width, height);
                };
                this._isEmpty = false;
            };

            SignaturePad.prototype._strokeUpdate = function(event) {
                var point = this._createPoint(event);
                if (this._isPointToBeUsed(point)) {
                    this._addPoint(point);
                }
            };

            var pointsSkippedFromBeingAdded = 0;
            SignaturePad.prototype._isPointToBeUsed = function(point) {
                // Simplifying, De-noise
                if (!this.minPointDistance)
                    return true;

                var points = this.points;
                if (points && points.length) {
                    var lastPoint = points[points.length - 1];
                    if (point.distanceTo(lastPoint) < this.minPointDistance) {
                        // log(++pointsSkippedFromBeingAdded);
                        return false;
                    }
                }
                return true;
            };

            SignaturePad.prototype._strokeBegin = function(event) {
                this._reset();
                this._strokeUpdate(event);
                if (typeof this.onBegin === 'function') {
                    this.onBegin(event);
                }
            };

            SignaturePad.prototype._strokeDraw = function(point) {
                var ctx = this._ctx,
                    dotSize = typeof(this.dotSize) === 'function' ? this.dotSize() : this.dotSize;

                ctx.beginPath();
                this._drawPoint(point.x, point.y, dotSize);
                ctx.closePath();
                ctx.fill();
            };

            SignaturePad.prototype._strokeEnd = function(event) {
                var canDrawCurve = this.points.length > 2,
                    point = this.points[0];

                if (!canDrawCurve && point) {
                    this._strokeDraw(point);
                }
                if (typeof this.onEnd === 'function') {
                    this.onEnd(event);
                }
            };

            SignaturePad.prototype._handleMouseEvents = function() {
                this._mouseButtonDown = false;

                this._canvas.addEventListener("mousedown", this._handleMouseDown);
                this._canvas.addEventListener("mousemove", this._handleMouseMove);
                document.addEventListener("mouseup", this._handleMouseUp);
            };

            SignaturePad.prototype._handleTouchEvents = function() {
                // Pass touch events to canvas element on mobile IE11 and Edge.
                this._canvas.style.msTouchAction = 'none';
                this._canvas.style.touchAction = 'none';

                this._canvas.addEventListener("touchstart", this._handleTouchStart);
                this._canvas.addEventListener("touchmove", this._handleTouchMove);
                this._canvas.addEventListener("touchend", this._handleTouchEnd);
            };

            SignaturePad.prototype.on = function() {
                this._handleMouseEvents();
                this._handleTouchEvents();
            };

            SignaturePad.prototype.off = function() {
                this._canvas.removeEventListener("mousedown", this._handleMouseDown);
                this._canvas.removeEventListener("mousemove", this._handleMouseMove);
                document.removeEventListener("mouseup", this._handleMouseUp);

                this._canvas.removeEventListener("touchstart", this._handleTouchStart);
                this._canvas.removeEventListener("touchmove", this._handleTouchMove);
                this._canvas.removeEventListener("touchend", this._handleTouchEnd);
            };

            SignaturePad.prototype.isEmpty = function() {
                return this._isEmpty;
            };

            SignaturePad.prototype._reset = function() {
                this.points = [];
                this._lastVelocity = 0;
                this._lastWidth = (this.minWidth + this.maxWidth) / 2;
                this._isEmpty = true;
                this._ctx.fillStyle = this.penColor;
            };

            SignaturePad.prototype._createPoint = function(event) {
                var rect = this._canvas.getBoundingClientRect();
                return new Point(
                    event.clientX - rect.left,
                    event.clientY - rect.top
                );
            };

            SignaturePad.prototype._addPoint = function(point) {
                var points = this.points,
                    c2, c3,
                    curve, tmp;

                points.push(point);

                if (points.length > 2) {
                    // To reduce the initial lag make it work with 3 points
                    // by copying the first point to the beginning.
                    if (points.length === 3) points.unshift(points[0]);

                    tmp = this._calculateCurveControlPoints(points[0], points[1], points[2]);
                    c2 = tmp.c2;
                    tmp = this._calculateCurveControlPoints(points[1], points[2], points[3]);
                    c3 = tmp.c1;
                    curve = new Bezier(points[1], c2, c3, points[2]);
                    this._addCurve(curve);

                    // Remove the first element from the list,
                    // so that we always have no more than 4 points in points array.
                    points.shift();
                }
            };

            SignaturePad.prototype._calculateCurveControlPoints = function(s1, s2, s3) {
                var dx1 = s1.x - s2.x,
                    dy1 = s1.y - s2.y,
                    dx2 = s2.x - s3.x,
                    dy2 = s2.y - s3.y,

                    m1 = {
                        x: (s1.x + s2.x) / 2.0,
                        y: (s1.y + s2.y) / 2.0
                    },
                    m2 = {
                        x: (s2.x + s3.x) / 2.0,
                        y: (s2.y + s3.y) / 2.0
                    },

                    l1 = Math.sqrt(1.0 * dx1 * dx1 + dy1 * dy1),
                    l2 = Math.sqrt(1.0 * dx2 * dx2 + dy2 * dy2),

                    dxm = (m1.x - m2.x),
                    dym = (m1.y - m2.y),

                    k = l2 / (l1 + l2),
                    cm = {
                        x: m2.x + dxm * k,
                        y: m2.y + dym * k
                    },

                    tx = s2.x - cm.x,
                    ty = s2.y - cm.y;

                return {
                    c1: new Point(m1.x + tx, m1.y + ty),
                    c2: new Point(m2.x + tx, m2.y + ty)
                };
            };

            SignaturePad.prototype._addCurve = function(curve) {
                var startPoint = curve.startPoint,
                    endPoint = curve.endPoint,
                    velocity, newWidth;

                velocity = endPoint.velocityFrom(startPoint);
                velocity = this.velocityFilterWeight * velocity +
                    (1 - this.velocityFilterWeight) * this._lastVelocity;

                newWidth = this._strokeWidth(velocity);
                this._drawCurve(curve, this._lastWidth, newWidth);

                this._lastVelocity = velocity;
                this._lastWidth = newWidth;
            };

            SignaturePad.prototype._drawPoint = function(x, y, size) {
                var ctx = this._ctx;

                ctx.moveTo(x, y);
                ctx.arc(x, y, size, 0, 2 * Math.PI, false);
                this._isEmpty = false;
            };

            SignaturePad.prototype._drawMark = function(x, y, size) {
                var ctx = this._ctx;

                ctx.save();
                ctx.moveTo(x, y);
                ctx.arc(x, y, size, 0, 2 * Math.PI, false);
                ctx.fillStyle = 'rgba(255, 0, 0, 0.2)';
                ctx.fill();
                ctx.restore();
            };

            SignaturePad.prototype._drawCurve = function(curve, startWidth, endWidth) {
                var ctx = this._ctx,
                    widthDelta = endWidth - startWidth,
                    drawSteps, width, i, t, tt, ttt, u, uu, uuu, x, y;

                drawSteps = Math.floor(curve.length());
                ctx.beginPath();
                for (i = 0; i < drawSteps; i++) {
                    // Calculate the Bezier (x, y) coordinate for this step.
                    t = i / drawSteps;
                    tt = t * t;
                    ttt = tt * t;
                    u = 1 - t;
                    uu = u * u;
                    uuu = uu * u;

                    x = uuu * curve.startPoint.x;
                    x += 3 * uu * t * curve.control1.x;
                    x += 3 * u * tt * curve.control2.x;
                    x += ttt * curve.endPoint.x;

                    y = uuu * curve.startPoint.y;
                    y += 3 * uu * t * curve.control1.y;
                    y += 3 * u * tt * curve.control2.y;
                    y += ttt * curve.endPoint.y;

                    width = startWidth + ttt * widthDelta;
                    this._drawPoint(x, y, width);
                }
                ctx.closePath();
                ctx.fill();
            };

            SignaturePad.prototype._strokeWidth = function(velocity) {
                return Math.max(this.maxWidth / (velocity + 1), this.minWidth);
            };

            var Point = function(x, y, time) {
                this.x = x;
                this.y = y;
                this.time = time || new Date().getTime();
            };

            Point.prototype.velocityFrom = function(start) {
                return (this.time !== start.time) ? this.distanceTo(start) / (this.time - start.time) : 1;
            };

            Point.prototype.distanceTo = function(start) {
                return Math.sqrt(Math.pow(this.x - start.x, 2) + Math.pow(this.y - start.y, 2));
            };

            var Bezier = function(startPoint, control1, control2, endPoint) {
                this.startPoint = startPoint;
                this.control1 = control1;
                this.control2 = control2;
                this.endPoint = endPoint;
            };

            // Returns approximated length.
            Bezier.prototype.length = function() {
                var steps = 10,
                    length = 0,
                    i, t, cx, cy, px, py, xdiff, ydiff;

                for (i = 0; i <= steps; i++) {
                    t = i / steps;
                    cx = this._point(t, this.startPoint.x, this.control1.x, this.control2.x, this.endPoint.x);
                    cy = this._point(t, this.startPoint.y, this.control1.y, this.control2.y, this.endPoint.y);
                    if (i > 0) {
                        xdiff = cx - px;
                        ydiff = cy - py;
                        length += Math.sqrt(xdiff * xdiff + ydiff * ydiff);
                    }
                    px = cx;
                    py = cy;
                }
                return length;
            };

            Bezier.prototype._point = function(t, start, c1, c2, end) {
                return start * (1.0 - t) * (1.0 - t) * (1.0 - t) +
                    3.0 * c1 * (1.0 - t) * (1.0 - t) * t +
                    3.0 * c2 * (1.0 - t) * t * t +
                    end * t * t * t;
            };

            return SignaturePad;
        })(document);

        var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)',
            velocityFilterWeight: .7,
            minWidth: 0.5,
            maxWidth: 2.5,
            throttle: 16, // max x milli seconds on event update, OBS! this introduces lag for event update
            minPointDistance: 3,
        });
        var saveButton = document.getElementById('save'),
            clearButton = document.getElementById('clear'),
            showPointsToggle = document.getElementById('showPointsToggle');
        var signatureInput = document.getElementById('signature');
        saveButton.addEventListener('click', function(event) {
            if (signaturePad.isEmpty()) {
                alert('Please provide your signature.');
                event.preventDefault();
            } else {
                var data = signaturePad.toDataURL('image/png');
                signatureInput.value = data;
            }
        });
        clearButton.addEventListener('click', function(event) {
            signaturePad.clear();
        });
        showPointsToggle.addEventListener('click', function(event) {
            signaturePad.showPointsToggle();
            showPointsToggle.classList.toggle('toggle');
        });
    </script>
   
</body>

</html>
