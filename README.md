Redesign needed
===============

Hi, I'm here to ask you suggestions on (why and) how redesign the Order model we are currently use, expecially involving the totals calculation.

The code in this repo is extremely reduced from it's original (big) state in order to focus the attention only on this desing problem.

What's the deal?
----------------

Well, take a look at `Order::getTotalAmount` function: the `if` statement, in our opinion, **smells a lot**.

Furthermore, the method is logically coupled to (or if you prefer, is a duplication of the behaviour of) `Order::confirm` method.

What about Strategy pattern?
----------------------------

Strategy pattern is already applied: this is a restricted version of our library, but we have 11 order statuses (here not shown) that take care of a part of Order business logic; we do not want to delegate the amount calculation in the statuses classes too.

But even if we accept to delegate the calc to the statuses, this means we have to expose a lot of dependancies to the outside world of Order class, and we are against it.

Possible solutions
------------------

A possible solution is to split up Order class (for ex through subclassing/polymorphism), but it's not clear to us **how to transform** a pending order to a confirmed order in a way **totally hidden (or enough hidden)** to the world.
