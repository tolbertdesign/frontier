Naming Convention — 9 Basic Rules for any Piece of Code

Ran Greenberg Oct 10, 2019 · 5 min read

https://medium.com/wix-engineering/naming-convention-8-basic-rules-for-any-piece-of-code-c4c5f65b0c09

    “The ratio of time spent reading (code) versus writing is well over 10 to 1 … (therefore) making it easy to read makes it easier to write.” — Robert C. Martin

Photo by Brett Jordan on Unsplash

The naming convention is a very contentious topic. Everyone has their own style
when it comes to naming variables, functions, classes, and even documentation.

There is no single or standard way to name your code parts. Definition

    “Naming convention is a set of rules for choosing the character sequence to be used for identifiers which denote variables, types, functions, and other entities in source code and documentation” — Wikipedia

The Challenge

    “The hardest thing about choosing good names is that it requires good descriptive skills and a shared cultural background. This is a teaching issue rather than a technical, business or management issue.”

We’re all different and from different backgrounds. One can describe a thing
completely different for others. More than that, people from different cultures
can describe the same things differently. Selecting the proper name for a
function or a variable requires experience and many hours of code reading. This
challenge is not a technical or management challenge, it’s a skill that requires
much practice. Rule #1 — Consistency Pick One Word per Concept — Use the same
concept across the codebase

fetchData() {...}getData() {...}retrieveData() {...}

All 3 names of the above methods are the same and can be interpreted as the same
operation. It doesn’t matter which one we actually pick, but it’s important that
we’re consistent throughout the code. If we decide that fetch will request data
remotely, we should stick with that convention for fetchPermissions and
fetchUserDetails for instance. Rule #2 — Meaningful Characters are cheap,
confusion is expansive

😳 const users; 😎 const numberOfUsers; 😳 const friends; 😎 const
friendsOfCurrentUser;

We write code with a 100% mindset of that feature or context. We forget that the
next reader might come with a different mindset, so we should make sure we avoid
ambiguity. For instance, in function scope, we wrote users but we actually meant
numberOfUsers, which can be misleading. Or if we wanted to create a variable
with all the current user’s friends, we should name it
friendsOfCurrentUserrather than friends. Rule #3 — Meaningful Distinctions Use
the same word for the same purpose

Two different things in the same scope? You might be tempted to change one name
😡

What is these functions’ return? 😕

getUserDetails() {...} getUserInfo() {...} getUserData() {...}

What’s the difference between details/info/data anyway?!

If we have 2 definitions for “not that different” object/class/variable we
should consider aggregating its content differently. Or changing one of the
names dramatically.

Another use-case:

// Function in Class A function add(x, y) { return x + y; }// Function in Class
B function add(x) { this.items.add(x); }

In class A, the add(x, y) function adding 2 numbers and in class B add(x) is
insert element to the collection. Both functions' names are correct, but without
deep-dive to their implementations, you won’t be able to understand and use
them. A better name will be:

add(x, y) -> addNumbers(x, y)

add(x) -> insertElement(x) Rule #4 — Avoid Encodings Avoid unnecessary encodings
of data-types along with the variable name

string urlString; int numberOfMembersInt; Array<string> namesArray;

It might look good and be a useful practice, but in order to scale, this
ambiguity will be annoying and hard to maintain. The name should be a higher
abstraction level of the implementation details of the actual variable type.
Rule #5— Use Pronounceable Names Nobody wants a tongue twister or a
non-searchable words

const lblFName; //first name label const nowTsMs; //now date timestemp since
1970 in milliseconds

These kinds of variables names are hard to pronounce and no one will be able to
remember them, aside from the writer themself.

Moreover, our code should be able to be searchable. When the project becomes
bigger and bigger we will search more and more. Better naming make scaling
easier. Rule #6 — Don’t Be Offensive/Cute Don’t be a serial killer behind your
code

function killThemAll(); function whack(); function giveSomeLove()

Some projects are open-source, some are cross-cultural. The name you pick for
your function will be read by a variety of people. The same thing can be
interpreted differently between different people.

Naming convention should be generic, and as professional as possible, and should
not include any cultural slang. Rule #7 — Be Positive
shouldNotShowIfDisabledIsFalse ✌️

isDisabled should become isEnabled

isUndefined should become isDefined

shouldNotShowScreen should become shouldShowScreen

avoidBroadcast should become doBroadcast

broadcastNotArrived() should become broadcastArrived({})

As humans, we have a better understanding of the positive approach (besides the
new-age approach 😎) so we should use them in the names we pick. Rule #8 —
Helper to the Manager with some Utils 🙄

NetworkHelper RequestManager HttpUtils

These names above are just a way to ignore the challenges of select a
descriptive name to that piece of code. No one really understands what has
inside these files (or classes) or what does it do.

We better avoid these names, by avoiding that we’ll arrange our code better and
won’t give life to these god objects. Rule #9— Awareness 🤖 Characters are
cheap, confusion is expansive

A few general bullets to keep in mind while we coding:

    We are NOT the only ones who read our code
    Our mood is NOT related to the code we’re writing
    Humans read our code, not computers
    Read your code after you write it

Summary

Naming is hard. Naming depends on your current mood and vibe. You can’t beat
that. More often than not, we’ll re-read the names we picked, the more readable
the code will be. The main focus of this article is raising awareness. Keep that
in mind that you’re writing code for humans. Keep that in mind that someone
needs to read what you wrote and actually understand it.

Hope you liked it! If so, don’t be shy to 👏 and share.

Awareness Naming ✌️ #goodlife
