# Eloquent Aggregate Relationships

[![Build Status](https://travis-ci.org/andyfleming/eloquent-aggregate-relationships.svg?branch=master)](https://travis-ci.org/andyfleming/eloquent-aggregate-relationships) [![Code Climate](https://codeclimate.com/github/andyfleming/eloquent-aggregate-relationships/badges/gpa.svg)](https://codeclimate.com/github/andyfleming/eloquent-aggregate-relationships)

## *Work-in-progress*

This laravel package provides tools for easily creating aggregate relationships that can be eager-loaded.

The primary issue is that eloquent out of the box won't let you eager-load and count a relationship without loading all of actual records of that relationship.

## Proposed sytnax

```php
public function commentsCount() {
    return $this->countHasMany('Comment','post_id','comments_count');
}
```

```php
$this->averageHasMany(...
```

```php
$this->sumHasMany(...
```

etc

---

## Project Inspiration

This project was inspired by the blog post [Tweaking Eloquent relations – how to get hasMany relation count efficiently?](http://softonsofa.com/tweaking-eloquent-relations-how-to-get-hasmany-relation-count-efficiently/) by Jarek Tkaczyk ([@SOFTonSOFA](https://twitter.com/SOFTonSOFA)).

The post provided a solution for counting a relationship effeciently with the following syntax:

```php
public function commentsCount()
{
  return $this->hasOne('Comment')
    ->selectRaw('post_id, count(*) as aggregate')
    ->groupBy('post_id');
}
```

