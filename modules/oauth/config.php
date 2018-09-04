<?php

return [
	"src" => dirname(__FILE__).'/src/',
	"login_url" => "http://localhost:8888/oauth/login",
	"return_url" => "http://localhost:8888/oauth/example",

	"facebook" => array(
		"status" => 1,
		"app_id" => "167885977352",
		"app_secret" => "70cdc6459125f3ce8327fe5ece09f",
		"default_graph_version" => "v2.5",
	),
	"google" => array(
		"status" => 1,
		"clientId" => "1093260479743-4s3u00lai3aa420c8t4j3v2qpdri.apps.googleusercontent.com",
		"clientSecret" => "ErEcnUptfXP0FO2-15Xt",
		"ApplicationName" => " Your App Name ",
	),
	"twitter" => array(
		"status" => 1,
		"consumer_key" => "iZO5Ln9bcIX3F1mXOqIiODN",
		"consumer_secret" => "9vPPjgkSbf7fV5YxOwD26Z8gn2kAlnrB6ntAAHqsknHTfsR",
	)
];