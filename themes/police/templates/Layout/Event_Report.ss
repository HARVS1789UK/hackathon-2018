<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h1>$Title</h1>
            <h2>Report</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <section>
                $Content
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <form action="{$Link}add" method="post">
                <fieldset>
                    <div class="form-group">
                        <label for="Severity">Severity<span class="required">*</span></label>
                        <select class="form-control" name="Severity" id="Severity">
                            <option disabled selected required value="">- Please Select - </option>
                            <option value="critical">Critical</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                            <option value="notice">Notice</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Category">Category<span class="required">*</span></label>
                        <select class="form-control" name="Category" id="Category">
                            <option disabled selected required value="">- Please Select - </option>
                            <option value="traffic-accident">Traffic Accident</option>
                            <option value="traffic-congestion">Traffic Congestion</option>
                            <option value="weather-obstruction">Weather Obstruction</option>
                            <option value="utilities-obstruction">Utilities Obsruction</option>
                            <option value="livestock-obstruction">Livestock Obstruction</option>
                            <option value="planned-closure">Planned Closure</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Comment">Comments</label>
                        <textarea class="form-control" name="Comment"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Location">Location<span class="required">*</span></label>
                        <p class="js--describe-central-location">Select a location on the map</p>
                        <input class="js--central-longitude js--map-data" type="hidden" name="Longitude" value="" />
                        <input class="js--central-latitude js--map-data" type="hidden" name="Latitude" value="" />
                    </div>
                    <div class="form-group">
                        <label for="Routes">Affected Route</label>
                        <p><strong>Start:</strong> <span class="js--describe-route-start">Please select a central point first</span></p>
                        <p><strong>End:</strong> <span class="js--describe-route-end">Please select a start point first</span></p>
                        <input type="hidden" class="js--map-data js--route-name" name="Route[Name]" value="" />
                        <input type="hidden" class="js--map-data js--start-latitude" name="Route[Start][Latitude]" value="" />
                        <input type="hidden" class="js--map-data js--start-longitude" name="Route[Start][Longitude]" value="" />
                        <input type="hidden" class="js--map-data js--end-latitude" name="Route[End][Latitude]" value="" />
                        <input type="hidden" class="js--map-data js--end-longitude" name="Route[End][Longitude]" value="" />
                        <div class="js--waypoints-wrapper"></div>
                    </div>
                    <div class="form-group">
                        <label for="Start">In Effect From</label>
                        <input class="form-control" type="datetime-local" name="Start" value="" />
                    </div>
                    <div class="form-group">
                        <label for="End">In Effect Till</label>
                        <input class="form-control" type="datetime-local" name="End" value="" />
                    </div>
                    <button type="submit" disabled class="btn btn-primary js--submit-button">Submit Report</button>
                </fieldset>
            </form>
        </div>
        <div class="map-wrapper col-xs-12 col-md-8">
            <div id="map">
                <p>Interactive map to report highway events to go here</p>
            </div>
        </div>
    </div>
</div>
<script src="/resources/themes/police/js/maps.js" type="text/javascript"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCezeMq2iwQlNA0Nfg0J9zjfda_oXaCW-0&callback=initMap"
  type="text/javascript"></script>