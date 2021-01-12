<?php

if (isset($_GET['action'])) {
	$action = $_GET['action']; 
} else {
	$action = null; 
}

require ('socAllPage.php');
require ('database_connect.php'); // database connection onto socAllPage

$title = 'About Us'; 

$content = <<<HTML
	<div id="col_left">
		<div class="panel_left">
			<h1>Seventeen years fighting for socialist unity</h1>
	
			<p class="first">The first Socialist Alliance was set up in Coventry in 1992 and the first national meeting held in 1996 with eight local alliances represented. Within two years 20 local alliances and twelve left groups had joined. During the next two years the project took off with 58 local SA’s across the country.</p>
	
			<p>In 2001 the SA adopted a new programme and constitution and now involved all the main tendencies and groupings on the left, including the AWL, CPGB, International Socialist Group, Revolutionary Democratic Group, Socialist Party, SWP and Workers Power. The SA stood 98 candidates in the 2001 general election, making the biggest left challenge to the Labour Party for 50 years.</p>
	
			<p>After the Bush-Blair war in Iraq, the SWP majority abandoned the SA for Respect and closed the SA down. However a significant minority did not accept this. In November 2005 the SA was relaunched at the London conference. The need for non-sectarian socialist unity remains central to the struggle for socialism. The Socialist Alliance is back.</p>
	
			<h2>LEFT UNITY AS PART OF THE PROCESS OF BUILDING A NEW LEFT PARTY - A PRIORITY FOR THE SA</h2>
	
			<p>The re-launched SA has prioritised the need for a new workers’ party, based solidly within the working class, and work around socialist unity initiatives.  <span style="font-weight: bold;">The ultimate aim is to unite all such unity projects under one umbrella.  </span>The November 2007 SA AGM specified our most urgent aim as being to campaign for a new alliance of socialists which unites in one organisation the Labour Representation Committee, the CNWP, Respect, tUSP and the rest of the socialist and green socialist left.</p>
	
			<p>As part of this process, the SA decided to approach all socialist unity projects and left organisations to discuss ways of uniting the left.  This led to a Left Unity Meeting on July 5th attended by 12 left organisations/unity-projects, including all the main players.</p>
	
			<h3>SGUC AND CNWP</h3>
	
			<p>The SA, SP, AGS, AWL and DLP founded the Socialist Green Unity Coalition (SGUC) four years ago, largely to try and obtain electoral unity across the socialist and green socialist left, or at least to avoid clashes. Clashes have been entirely avoided within the coalition, which has also agreed and published extensive sets of jointly agreed policies for general and local elections. The SGUC has also jointly sought clash avoidance agreements with other left and green parties, with limited success.<br><br>The SA is also an integral part of the <span style="font-weight: bold;">Campaign for a New Workers’ Party</span> (CNWP), being affiliated since its launch.  The SA itself campaigns for a new workers’ party, and sees the CNWP as an umbrella that could achieve it.  SA policies have helped the CNWP to develop.  It has become a membership organisation, and the CNWP agreed at this year’s Conference to a SA resolution stating that the time was right to start moving towards a pro-party alliance or a pre-party formation that, as well as campaigning for a new party, would also begin work to determine the structure and rules for such a party.  The CNWP also agreed with the SA view that, as part of the process of building a new workers’ party, it was necessary to bring together as many of the disparate left forces as possible, in addition to the work being done to build the Party within the working class.  Clearly the SA would prefer this to happen through the CNWP as structures are already in place, and the CNWP has over 3,500 signed up supporters, but we understand why others may have alternative suggestions</p>
	
			<h3>SPECIFIC SA PRINCIPLES WHEN WORKING WITH OTHER GROUPS</h3>
	
			<p>When working with others, the SA would want to encourage</p>
	
			<ul>
				<li>Openness of ideas and freedom of expression</li><li>An anti sectarian, co-operative and positive way of working</li>
	
				<li>Building a structure that was democratic and inclusive; prevented domination by any one group; encouraged affiliation and automatic representation for all supportive political organisations, and representation for independents</li>
			</ul>
	
			<p>The SA sees no barriers to working with others as long as there is a willingness to co-operate along these principles<br></p>
	
			<h3>LEFT LIAISON COMMITTEE</h3>
	
			<p style="font-weight: bold;">The SA called the Left Unity meeting on July 5, and would fully support this Left Unity initiative becoming a sort of Left Liaison Committee to have dialogue on the unity process as it unfolds<br></p>
	
			<h3>DEVELOPMENTS SINCE JULY 2008</h3>
	
			<p>There have now  been five meetings of what has now become to be called the Left Unity Liaison Committee (LULC) - reports from these five meetings can be found under the heading ‘Left Unity’ above. All the main socialist and green socialist organisations have attended, and in total 15 left groups have sent representatives to discuss and promote left unity.  These are the Socialist Party, Respect, the Labour Representation Committee, the Campaign for a New Workers Party, CPGB, Workers Power, the Democratic Labour Party, Workers Liberty, the Communist Party (CPB), RDG, Socialist alliance, Green Left, Alliance for Green Socialism, the United Socialist Party, Left Alternative.  At long last, the left is talking to each other again.<br><br>At the 2008 SA AGM, it was agreed that we promote One Party for the Left based solidly within the working class - with the intention that such a party would have support from trade unions, tenants groups, women, youth, black groups, anti-war protesters and environmentalist - within the Left Unity Liaison Committee, the CNWP and the socialist movement generally.  It was for this reason that we agreed to support the RMT initiated slate for the European Elections in June 2009, ‘No2EU-yestoDemocracy’ (see link above).  SA National Secretary Pete McLaren was a candidate in the West Midlands, where Dave Nellist headed the list, and one past member, and a present one, stood in London and Yorkshire respectively.  A number of SA members actively supported the campaign.  We now hope that post No2EU developments will lead, at the very least, to a unified left list of candidates for the General election.  It is SA policy to engage in any post No2EU Left developments which broadly fit within our agreed policies as in our Constitution.  We are hopeful a new Left Party will emerge from such developments, and we will work within the LULC and CNWP to win others to that position.</p>

			<img class="panel_bottom" src="graphics/content_BG_bottom.gif"/>
		</div>
	</div>

	<div id="col_right">
		<div class="panel_right">
			<h2>Branches, affiliates and supporters</h2>

			<p>Alliance for Green Socialism</p>
			<p>Bedfordshire SA</p>
			<p>Brighton</p>
			<p>Bristol</p>
			<p>Coventry &amp; Warwickshire SA</p>
			<p>Leeds</p>
			<p>London and South-East SA</p>
			<p>Merseyside SA</p>
			<p>Newcastle</p>
			<p>Revolutionary Democratic Group</p>
			<p>Rugby Red-Green Alliance</p>
			<p><a href="http://groups.yahoo.com/group/SotonSA/" class="newWindow">Southampton SA</a></p>
			<p>Walsall Democratic Labour Party</p>

			<img class="panel_bottom" src="graphics/panel_BG_bottom.gif"/>
		</div>
	</div>
HTML;

$contact = new SocAllPage($title, $content);

$contact->writePage();

require('database_close.php'); 

?>