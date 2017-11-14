Author: Dynamic Drive
Feb 16th, 12' (v2.0): Added option ("scrolltoheader") to scroll to the expanded header in question after it expands (useful if a header contains long content).

Description: Group contents together and reveal them on demand when the user clicks on their associated headers, with Accordion content script! Specify whether only one content within the group should be open at any given time, style the headers depending on their content state, and even enable persistence so the state of the contents is preserved within a browser session. The script enlists the help of the jQuery library for its engine. There are lots of configurable options, so lets get to them:

Headers and their contents to expand/collapse on the page are identified through the use of shared CSS class names for easy set up.
Ability to specify which contents should be expanded by default when the page first loads.
Specify whether only one content should be open at any given time (collapse previous before expanding current.
Ajax content support added, so a given header's content can be dynamically fetched from an external file and only when requested. New in v1.9
Specify whether at least one header should be open at all times (so never all closed).
Set whether the headers should be activated "click" or "mouseover". If the headers themselves are hyperlinked and set to activate via "click", you can optionally have the browser go to that URL upon expanding the content, instead of doing nothing. New in v1.7
Ability to scroll to the expanded header in question after it expands, which is useful if the header contains a lot of content and expanding it changes the scroll position of the document. New in v2.0
When headers are set to be activated "mouseover", set delay (in millisec) before this happens. New in v1.6
Enable optional persistence so when the user expands a header then returns to the page within the same browser session, the content state is preserved.
Style the two states of the headers easily by setting two different CSS classes to be added to the header depending on whether its content is expanded or collapsed. You can also add additional HTML to the beginning or end of each header, such as an icon image that reflects the current state of the content.
Two event handlers oninit() and onopenclose() can be used to run custom code when an Accordion Content first loads and whenever a header is opened/closed, respectively.
Arbitrary links can be defined elsewhere on the page performing the same functions as if the user had directly clicked on a header, such as expand a particular header, toggle a header, or expand all headers within a group.
A link from another page linking to the target page can cause the desired headers on the later to expand when loaded, via the URL parameter string.
You don't have to be an accordion player to appreciate this script!